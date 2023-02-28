import "./bootstrap";
import "laravel-datatables-vite";

window.draw_popovers = () => {
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );

    support_note_event_listener();
};

window.initalize_datatable = (table) => {
    table
        .api()
        .columns()
        .every(function () {
            const column = this;
            $('<input type="text" class="form-control">')
                .appendTo($(column.header()))
                .on("input", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    console.log(val);
                    column.search(val).draw();
                });
        });
};

draw_popovers();

function support_note_event_listener() {
    const support_note_forms = document.querySelectorAll(".support_note_form");
    Array.from(support_note_forms).forEach((form) => {
        const support_note = form.querySelector("textarea");
        console.log(support_note);

        support_note.addEventListener("input", async (e) => {
            e.preventDefault();

            const status_element = e.target.parentElement.querySelector(
                "#support_note_status"
            );
            const id = form.dataset.id;
            const support_note = e.target.value;

            add_loading(status_element, "Saving ...");
            await axios.post(route("order.update_support_note", id), {
                support_note,
            });
            remove_loading(status_element, "Saved");
        });
    });
}

function add_loading(element, text) {
    const loading_icon = `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>`;
    element.setAttribute("disabled", "");
    element.innerHTML = loading_icon + text;
}

function remove_loading(element, text) {
    element.innerHTML = text;
    element.removeAttribute("disabled");
}

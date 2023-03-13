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
draw_popovers();

window.initalize_datatable = (table) => {
    // Custom filters
    const column_order_status = 3;
    const default_order_status = "processing";
    // Default option
    table.api().column(column_order_status).search(default_order_status).draw();
    // Select on change search
    document
        .getElementById("filter-order-status")
        .addEventListener("change", (e) => {
            table
                .api()
                .column(column_order_status)
                .search(e.target.value)
                .draw();
        });

    table
        .api()
        .columns()
        .every(function () {
            const column = this;
            $('<input type="text" class="form-control">')
                .appendTo($(column.header()))
                .on("input", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val).draw();
                });
        });
};

function support_note_event_listener() {
    Echo.channel("notes").listen(".support-note", (event) => {
        const support_note_textarea = document.querySelector(
            `#support_note_${event.order.id}`
        );
        const form = support_note_textarea.parentElement;
        const status_element = form.querySelector("#support_note_status");
        add_loading(status_element, `${event.user.name} is typing...`);
        setTimeout(() => {
            const language = "fa";
            const date = new Date(event.on).toLocaleString(language);
            remove_loading(status_element, `${event.user.name} typed at (${date})`);
        }, 1000)
        support_note_textarea.value = event.message;
        console.log(event);
    });

    const support_note_forms = document.querySelectorAll(".support_note_form");

    // Debounce timeout
    let timeout = null;

    Array.from(support_note_forms).forEach((form) => {
        const support_note = form.querySelector("textarea");

        support_note.addEventListener("keyup", async (e) => {
            e.preventDefault();

            // Clear debounce timeout
            clearTimeout(timeout);

            const status_element = e.target.parentElement.querySelector(
                "#support_note_status"
            );
            const id = form.dataset.id;
            const support_note = e.target.value;

            add_loading(status_element, "Saving ...");

            // Create a new timeout and set to go off in 1000ms
            timeout = setTimeout(async () => {
                await axios.post(route("order.update_support_note", id), {
                    support_note,
                });
                remove_loading(status_element, "Saved");
            }, 1000);
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

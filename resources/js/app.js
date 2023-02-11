import "./bootstrap";
import "laravel-datatables-vite";

window.draw_popovers = () => {
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );
};

window.initalize_datatable = (table) => {
    table
        .api()
        .columns()
        .every(function () {
            var column = this;
            console.log(column);
            var select = $(
                '<select class="form-select"><option value="">Filter</option></select>'
            )
                .appendTo($(column.header()))
                .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                        .search(val ? "^" + val + "$" : "", true, false)
                        .draw();
                });

            column
                .data()
                .unique()
                .sort()
                .each(function (d, j) {
                    select.append(
                        '<option value="' + d + '">' + d + "</option>"
                    );
                });
        });
};

// function filter_notes(notes, type) {
//     return notes.filter((el) => (el.type.toLowerCase() === type.toLowerCase()));
// }

// window.draw_notes = function (row, type) {
//     console.log(row)
//     const notes = row.notes;
//     const filtered_notes = filter_notes(notes, type);
//     // console.log(filtered_notes);
//     const content_notes = [];
//     Array.from(filtered_notes).forEach((note) => {
//         if (note) { 
//             console.log(note);
//             content_notes.push(note.content);
//         }
//     });

//     return content_notes.join(" - ");
// };

draw_popovers();

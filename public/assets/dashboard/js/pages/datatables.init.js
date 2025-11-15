$(document).ready(function () {
    // Initialize DataTable only if elements exist
    if ($("#datatable").length) {
        $("#datatable").DataTable();
    }
    if ($("#datatable-buttons").length) {
        $("#datatable-buttons").DataTable({
            lengthChange: false,
            buttons: ["copy", "excel", "pdf", "colvis"]
        }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    }
    $(".dataTables_length select").addClass("form-select form-select-sm");
});
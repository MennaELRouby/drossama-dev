<!-- Required datatable js -->
<script src="{{ Path::dashboardPath('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ Path::dashboardPath('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ Path::dashboardPath('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/jszip/jszip.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ Path::dashboardPath('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Datatable init -->
<script>
    $(document).ready(function() {
        // تحقق مما إذا كان الجدول تم تهيئته مسبقاً
        if ($.fn.DataTable.isDataTable('#datatable-buttons')) {
            $('#datatable-buttons').DataTable().destroy();
        }

        // تهيئة الجدول
        $("#datatable-buttons").DataTable({
            lengthChange: false,
            buttons: ["copy", "excel", "pdf", "colvis"],
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            }
        }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    });
</script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!--sweetalert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @php
        use Illuminate\Support\Facades\Request;
        $currentUrl = Request::path();
        $segment = 'services';
    @endphp

    var currentUrl = @json($currentUrl);
    var segment = @json($segment);
    var url = @json(url("dashboard/$segment"));

    $(document).ready(function() {
        // تأكد من أن jQuery تم تحميله
        if (typeof $ === 'undefined') {
            console.error('jQuery is not loaded!');
            return;
        }

        // تأكد من أن زر الحذف موجود
        if ($('#btn_delete').length === 0) {
            console.error('Delete button not found!');
            return;
        }

        // Global "Check All" functionality
        $("#checkAll").change(function() {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        // Delete functionality
        $('#btn_delete').on('click', function(e) {
            e.preventDefault();
            console.log('Delete button clicked');

            var selectedCheckboxes = $(".check-inputs:checked");
            var selectedIds = [];

            selectedCheckboxes.each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: "undefined?",
                    text: "undefined",
                    icon: "warning",
                    confirmButtonColor: "#5156be"
                });
            } else {
                Swal.fire({
                    title: "{{ __('messages.are you sure') }}",
                    text: "{{ __('messages.remove checked values') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3086d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('messages.yes, delete it') }}!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                        console.log('Sending delete request to:', url + '/' + selectedIds[0]);
                        console.log('Selected IDs:', selectedIds);

                        $.ajax({
                            url: url + '/' + selectedIds[0],
                            type: 'DELETE',
                            data: {
                                selectedIds: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Deleted!",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // Remove the rows of deleted services
                                    selectedCheckboxes.each(function() {
                                        $(this).closest('tr').remove();
                                    });
                                } else {
                                    alert('An error occurred while deleting ');
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: error.responseJSON.message,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            }
        });

        // Change status functionality
        $('#btn_active').click(function() {
            var selectedCheckboxes = $(".check-inputs:checked");
            var selectedIds = [];

            selectedCheckboxes.each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: "undefined?",
                    text: "undefined",
                    icon: "warning",
                    confirmButtonColor: "#5156be"
                });
            } else {
                Swal.fire({
                    title: "undefined",
                    text: "undefined",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "undefined!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                        $.ajax({
                            url: url + "/change-status" + '/' + selectedIds,
                            type: 'POST',
                            data: {
                                selectedIds: selectedIds,
                                modelName: segment
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Reload the page to reflect the changes
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error!",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 5500
                                    });
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: error.responseJSON.message,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            }
        });
    });
</script>

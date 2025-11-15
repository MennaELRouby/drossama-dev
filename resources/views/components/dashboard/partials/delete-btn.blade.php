<script>
    @php
        $currentUrl = \Illuminate\Support\Facades\Request::path();
        $segments = explode('/', $currentUrl);
        // Get the last segment that's not empty and not a number (to handle /dashboard/sliders/1 cases)
$segment = '';
for ($i = count($segments) - 1; $i >= 0; $i--) {
    if (!empty($segments[$i]) && !is_numeric($segments[$i]) && $segments[$i] !== 'dashboard') {
                $segment = $segments[$i];
                break;
            }
        }
        $url = url("dashboard/$segment");
    @endphp

    // Define base delete URL for current section
    var url = @json($url);

    console.log('Delete button component loaded');
    console.log('Current URL:', @json($currentUrl));
    console.log('Segment:', @json($segment));
    console.log('Delete URL:', url);

    $(document).ready(function() {
        if (typeof $ === 'undefined') {
            console.error('jQuery is not loaded!');
            return;
        }

        if ($('#btn_delete').length === 0) {
            console.error('Delete button not found!');
            return;
        }

        $('#btn_delete').on('click', function(e) {
            e.preventDefault();

            var selectedCheckboxes = $(".check-inputs:checked");
            var selectedIds = [];

            selectedCheckboxes.each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: "{{ __('messages.no_select') }}",
                    text: "{{ __('messages.please select at least one') }}",
                    icon: "warning",
                    confirmButtonColor: "#5156be"
                });
                return;
            }

            Swal.fire({
                title: "{{ __('messages.are you sure') }}",
                text: "{{ __('messages.remove checked values') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('messages.yes, delete it') }}!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // For bulk delete, use the bulk delete route
                    var deleteUrl = selectedIds.length === 1 ? url + '/' + selectedIds[0] :
                        url + '/bulk';

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            selectedIds: selectedIds
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: "{{ __('messages.deleting') }}",
                                text: "{{ __('messages.please_wait') }}",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "{{ __('messages.deleted') }}",
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $(document).trigger('recordDeleted');

                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ __('messages.error') }}",
                                    text: response.message ||
                                        "{{ __('messages.an_error_occurred') }}"
                                });
                            }
                        },
                        error: function(xhr) {
                            var message = xhr.responseJSON?.message ||
                                "{{ __('messages.an_error_occurred') }}";
                            Swal.fire({
                                icon: "error",
                                title: "{{ __('messages.error') }}",
                                text: message
                            });
                        }
                    });
                }
            });
        });
    });
</script>

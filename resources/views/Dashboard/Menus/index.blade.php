<x-dashboard.layout :title="__('dashboard.menus')">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('dashboard.menus') }}</h4>

                    <div class="page-title-right d-flex align-items-center">
                        <div class="btn btn-list">
                            <a href="{{ route('dashboard.menus.create') }}" class="btn ripple btn-primary">
                                <i class="fas fa-plus-circle"></i> {{ __('dashboard.add') }}
                            </a>
                            <button id="btn_active" class="btn ripple btn-dark">
                                <i class="fas fa-eye"></i> {{ __('dashboard.publish/unpublish') }}
                            </button>
                            <button id="btn_delete" class="btn ripple btn-danger">
                                <i class="fas fa-trash"></i> {{ __('dashboard.delete') }}
                            </button>
                        </div>

                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.menus') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-table-container">

                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.name_en') }}</th>
                                    <th>{{ __('dashboard.name_ar') }}</th>
                                    <th>{{ __('dashboard.segment') }}</th>
                                    <th>{{ __('dashboard.parent') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr id="{{ $menu->id }}">
                                        <td class="text-center">
                                            <input type="checkbox" name="checkbox" class="check-inputs form-check-input"
                                                value="{{ $menu->id }}">
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.menus.edit', $menu->id) }}">{{ $menu->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.menus.edit', $menu->id) }}">{{ $menu->getTranslation('name', 'en') }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.menus.edit', $menu->id) }}">{{ $menu->getTranslation('name', 'ar') }}</a>
                                        </td>

                                        <td><a
                                                href="{{ route('dashboard.menus.edit', $menu->id) }}">{{ $menu->segment }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.menus.edit', $menu->id) }}">
                                                {{ $menu->parent_name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($menu->status == 1)
                                                <span class="status-badge active">{{ __('dashboard.yes') }}</span>
                                            @else
                                                <span class="status-badge inactive">{{ __('dashboard.no') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('dashboard.menus.toggle-status', $menu->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn-action {{ $menu->status ? 'unpublish' : 'publish' }}"
                                                        title="{{ $menu->status ? __('dashboard.unpublish') : __('dashboard.publish') }}">
                                                        <i
                                                            class="fas fa-{{ $menu->status ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('dashboard.menus.edit', $menu->id) }}"
                                                    class="btn-action edit" title="{{ __('dashboard.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.menus.destroy', $menu->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action delete"
                                                        title="{{ __('dashboard.delete') }}"
                                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end cardaa -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>

    @push('scripts')
        <x-dashboard.partials.datatable />
        <script>
            $(document).ready(function() {
                // تهيئة الجدول
                var table = initializeDataTable('#datatable-buttons');

                // تهيئة الـ checkboxes المحسنة مع تأخير
                setTimeout(function() {
                    initializeEnhancedCheckboxes();
                }, 1000);

                // إعادة تهيئة الـ checkboxes عند تغيير الجدول
                table.on('draw', function() {
                    setTimeout(function() {
                        initializeEnhancedCheckboxes();
                    }, 100);
                });

                // حل بسيط للـ checkboxes
                $(document).on('click', '.checkbox-enhanced', function(e) {
                    e.preventDefault();
                    var checkbox = $(this).find('input[type="checkbox"]');
                    var isChecked = checkbox.is(':checked');
                    checkbox.prop('checked', !isChecked);

                    if (checkbox.attr('id') === 'checkAll') {
                        $('.check-inputs').prop('checked', !isChecked);
                    } else {
                        var totalCheckboxes = $('.check-inputs').length;
                        var checkedCheckboxes = $('.check-inputs:checked').length;
                        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
                    }

                    // تحديث المظهر
                    setTimeout(function() {
                        $('.check-inputs:checked').closest('.checkbox-enhanced').addClass('checked');
                        $('.check-inputs:not(:checked)').closest('.checkbox-enhanced').removeClass(
                            'checked');

                        if ($('#checkAll').is(':checked')) {
                            $('#checkAll').closest('.checkbox-enhanced').addClass('checked');
                        } else {
                            $('#checkAll').closest('.checkbox-enhanced').removeClass('checked');
                        }
                    }, 10);
                });
            });

            // Bulk status change functionality
            $('#btn_active').on('click', function(e) {
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
                    text: "{{ __('messages.change checked status') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('messages.yes, change it') }}!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ route('dashboard.change.status', ['modelname' => 'menus', 'ids' => ':ids']) }}"
                                .replace(':ids', selectedIds.join(',')),
                            type: 'POST',
                            data: {
                                selectedIds: selectedIds,
                                modelName: 'menus'
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: "{{ __('messages.processing') }}",
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
                                        title: "{{ __('messages.updated') }}",
                                        text: response.message ||
                                            "{{ __('messages.status_changed_successfully') }}",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

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
        </script>
        <x-dashboard.partials.delete-btn />
    @endpush

    @section('script')
    @endsection
</x-dashboard.layout>

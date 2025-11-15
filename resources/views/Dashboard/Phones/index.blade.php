<x-dashboard.layout :title="__('dashboard.phones')">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('dashboard.phones') }}</h4>

                    <div class="page-title-right d-flex align-items-center">
                        <div class="btn btn-list">
                            <a href="{{ route('dashboard.phones.create') }}" class="btn ripple btn-primary">
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
                            <li class="breadcrumb-item active">{{ __('dashboard.phones') }}</li>
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
                    <div class="card-header">
                        <h4>{{ __('dashboard.phones') }}</h4>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">
                                        <div class="checkbox-enhanced">
                                            <input type="checkbox" id="checkAll" class="form-check-input">
                                            <span class="checkmark"></span>
                                        </div>
                                    </th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.name_en') }}</th>
                                    <th>{{ __('dashboard.name_ar') }}</th>
                                    <th>{{ __('dashboard.order') }}</th>
                                    <th>{{ __('dashboard.phone_number') }}</th>
                                    <th>{{ __('dashboard.phone_type') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($phones as $phone)
                                    <tr id="{{ $phone->id }}">
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" name="checkbox"
                                                    class="check-inputs form-check-input" value="{{ $phone->id }}">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.phones.edit', $phone->id) }}">{{ $phone->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.phones.edit', $phone->id) }}">{{ $phone->getTranslation('name', 'en') }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.phones.edit', $phone->id) }}">{{ $phone->getTranslation('name', 'ar') }}</a>
                                        </td>

                                        <td><a
                                                href="{{ route('dashboard.phones.edit', $phone->id) }}">{{ $phone->order }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.phones.edit', $phone->id) }}">
                                                {{ $phone->phone }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.phones.edit', $phone->id) }}">
                                                {{ $phone->type }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($phone->status == 1)
                                                <span class="status-badge active">{{ __('dashboard.yes') }}</span>
                                            @else
                                                <span class="status-badge inactive">{{ __('dashboard.no') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('dashboard.phones.edit', $phone->id) }}"
                                                    class="btn-action edit" title="{{ __('dashboard.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.phones.destroy', $phone->id) }}"
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
                    // initializeEnhancedCheckboxes();
                }, 1000);

                // إعادة تهيئة الـ checkboxes عند تغيير الجدول
                table.on('draw', function() {
                    setTimeout(function() {
                        // initializeEnhancedCheckboxes();
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
        </script>
        <x-dashboard.partials.delete-btn />
    @endpush

    @section('script')
    @endsection
</x-dashboard.layout>

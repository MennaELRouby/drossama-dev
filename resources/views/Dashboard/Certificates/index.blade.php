<x-dashboard.layout :title="__('dashboard.certificates')">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('dashboard.certificates') }}</h4>

                    <div class="page-title-right d-flex align-items-center">
                        <div class="btn btn-list">
                            <a href="{{ route('dashboard.certificates.create') }}" class="btn ripple btn-primary">
                                <i class="fas fa-plus-circle"></i> {{ __('dashboard.add') }}
                            </a>
                            <button id="btn_delete" class="btn ripple btn-danger">
                                <i class="fas fa-trash"></i> {{ __('dashboard.delete') }}
                            </button>
                        </div>

                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.certificates') }}</li>
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
                        <h4>{{ __('dashboard.certificates') }}</h4>
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
                                    <th>{{ __('dashboard.name') }}</th>
                                    <th>{{ __('dashboard.image') }}</th>
                                    <th>{{ __('dashboard.order') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($certificates as $certificate)
                                    <tr id="{{ $certificate->id }}">
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs form-check-input"
                                                    value="{{ $certificate->id }}">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.certificates.edit', $certificate->id) }}">{{ $certificate->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.certificates.edit', $certificate->id) }}">{{ $certificate->getTranslation('name', 'en') }}</a>
                                        </td>
                                        <td>
                                            @if ($certificate->image)
                                                <a href="{{ route('dashboard.certificates.edit', $certificate->id) }}">
                                                    <img src="{{ $certificate->image_path }}" width="70"
                                                        height="70" style="object-fit: cover; border-radius: 8px;">
                                                </a>
                                            @else
                                                <div class="no-image-placeholder">
                                                    <div>
                                                        <i class="fas fa-image"></i>
                                                        <br>NO IMAGE
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $certificate->order }}</td>
                                        <td>
                                            @if ($certificate->status == 1)
                                                <span class="status-badge active">{{ __('dashboard.yes') }}</span>
                                            @else
                                                <span class="status-badge inactive">{{ __('dashboard.no') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('dashboard.certificates.edit', $certificate->id) }}"
                                                    class="btn-action edit" title="{{ __('dashboard.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('dashboard.certificates.destroy', $certificate->id) }}"
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
            </div>
        </div>
    </div>

    @push('scripts')
        <x-dashboard.partials.datatable />
        <script>
            $(document).ready(function() {
                var table = initializeDataTable('#datatable-buttons');

                setTimeout(function() {
                    initializeEnhancedCheckboxes();
                }, 1000);

                table.on('draw', function() {
                    setTimeout(function() {
                        initializeEnhancedCheckboxes();
                    }, 100);
                });

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
</x-dashboard.layout>

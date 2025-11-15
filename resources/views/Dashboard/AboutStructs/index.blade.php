<x-dashboard.layout :title="__('dashboard.about_structs')">
    <div class="container-fluid">

        <!-- Page Header -->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('dashboard.about_structs') }}</h4>

                    <div class="page-title-right d-flex align-items-center">
                        <div class="btn btn-list">
                            <a href="{{ route('dashboard.about-structs.create') }}" class="btn ripple btn-primary">
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
                            <li class="breadcrumb-item active">{{ __('dashboard.about_structs') }}</li>
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
                        <h4>{{ __('dashboard.about_structs') }}</h4>
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
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($about_structs as $about_struct)
                                    <tr id="{{ $about_struct->id }}">
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs form-check-input"
                                                    value="{{ $about_struct->id }}">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.about-structs.edit', $about_struct->id) }}">{{ $about_struct->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.about-structs.edit', $about_struct->id) }}">{{ $about_struct->getTranslation('name', 'en') }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.about-structs.edit', $about_struct->id) }}">{{ $about_struct->getTranslation('name', 'ar') }}</a>
                                        </td>
                                        <td>
                                            @if ($about_struct->status == 1)
                                                <span class="status-badge active">{{ __('dashboard.yes') }}</span>
                                            @else
                                                <span class="status-badge inactive">{{ __('dashboard.no') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('dashboard.about-structs.edit', $about_struct->id) }}"
                                                    class="btn-action edit" title="{{ __('dashboard.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('dashboard.about-structs.destroy', $about_struct->id) }}"
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
       
        <x-dashboard.partials.delete-btn />
    @endpush
</x-dashboard.layout>

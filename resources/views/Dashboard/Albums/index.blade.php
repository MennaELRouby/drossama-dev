<x-dashboard.layout :title="__('dashboard.albums')">
    <div class="container-fluid">

        <!-- Page Header -->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('dashboard.albums') }}</h4>

                    <div class="page-title-right d-flex align-items-center">
                        <div class="btn btn-list">
                            <a href="{{ route('dashboard.albums.create') }}" class="btn ripple btn-primary">
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
                            <li class="breadcrumb-item active">{{ __('dashboard.albums') }}</li>
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
                        <h4>{{ __('dashboard.albums') }}</h4>
                    </div>
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
                                    <th>{{ __('dashboard.image') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($albums as $album)
                                    <tr id="{{ $album->id }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="check-inputs form-check-input"
                                                value="{{ $album->id }}">
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.albums.edit', $album->id) }}">{{ $album->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.albums.edit', $album->id) }}">{{ $album->name_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.albums.edit', $album->id) }}">{{ $album->name_ar }}</a>
                                        </td>
                                        <td>
                                            @if ($album->image_path && file_exists(public_path($album->image_path)))
                                                <a href="{{ route('dashboard.albums.edit', $album->id) }}">
                                                    <img src="{{ asset($album->image_path) }}" width="70"
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
                                        <td>
                                            @if ($album->status == 1)
                                                <span class="badge bg-success">{{ __('dashboard.yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('dashboard.no') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.albums.edit', $album->id) }}"
                                                class="btn btn-sm btn-primary" title="{{ __('dashboard.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dashboard.albums.destroy', $album->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    title="{{ __('dashboard.delete') }}"
                                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
        <script>
            $(document).ready(function() {
                // تهيئة الجدول البسيط
                if (!$.fn.DataTable.isDataTable('#datatable-buttons')) {
                    $('#datatable-buttons').DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "pageLength": 25,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                        }
                    });
                }

                // checkboxes بسيط
                $('#checkAll').on('click', function() {
                    $('.check-inputs').prop('checked', this.checked);
                });

                $('.check-inputs').on('click', function() {
                    var totalCheckboxes = $('.check-inputs').length;
                    var checkedCheckboxes = $('.check-inputs:checked').length;
                    $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
                });
            });
        </script>
    @endpush
</x-dashboard.layout>

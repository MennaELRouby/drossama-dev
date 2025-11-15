<x-dashboard.layout :title="__('dashboard.add_admin')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_admin')" :label_url="route('dashboard.admins.index')" :label="__('dashboard.admins')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_admin') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.admins.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ old('name') }}"
                                    placeholder="{{ __('dashboard.name') }}" required>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.email') }}</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}"
                                    placeholder="{{ __('dashboard.email') }}" required>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.password') }}</label>
                                <input class="form-control" name="password" type="password"
                                    placeholder="{{ __('dashboard.password') }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.confirm_password') }}</label>
                                <input class="form-control" name="password_confirmation" type="password"
                                    placeholder="{{ __('dashboard.password') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card card-permission">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">{{ __('dashboard.permissions') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Global Check All -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                                        <label class="form-check-label" for="checkAll">
                                                            {{ __('dashboard.check_all') }} (All Permissions)
                                                        </label>
                                                    </div>
                                                </div>

                                                @foreach ($permissionGroups as $group => $permissions)
                                                <div class="col-md-12 mb-6 head-border">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5>{{ $group }}</h5>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input check-all" data-group="{{ $group }}">
                                                            <label class="form-check-label">Check All</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($permissions as $key => $permission)
                                                        <div class="form-check col-2">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission->name }}"
                                                                class="form-check-input permission-checkbox-{{ $group }} permission-checkbox"
                                                                id="permission-{{ $permission->id }}">
                                                            <label class="form-check-label"
                                                                for="permission-{{ $permission->id }}">
                                                                {{ ucfirst(Illuminate\Support\Str::afterLast($permission->name, '.')) }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                {{ __('dashboard.save') }} </button>
                            <a href="{{ route('dashboard.admins.index') }}"><button type="button"
                                    class="btn btn-danger mr-1"><i class="icon-trash"></i>
                                    {{ __('dashboard.cancel') }}</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    @section('script')
    <style>
        .head-border {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-permission {
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }

        .form-check-input:indeterminate {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Global Check All functionality
            $('#checkAll').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.permission-checkbox').prop('checked', isChecked);
                $('.check-all').prop('checked', isChecked);
            });

            // Group Check All functionality
            $('.check-all').on('change', function() {
                var group = $(this).data('group');
                var isChecked = $(this).prop('checked');
                $('.permission-checkbox-' + group).prop('checked', isChecked);

                // Update global check all based on group status
                updateGlobalCheckAll();
            });

            // Individual checkbox change
            $('.permission-checkbox').on('change', function() {
                var group = $(this).attr('class').match(/permission-checkbox-(\S+)/)[1];
                var groupCheckboxes = $('.permission-checkbox-' + group);
                var checkedCount = groupCheckboxes.filter(':checked').length;
                var totalCount = groupCheckboxes.length;

                // Update group check all
                $('[data-group="' + group + '"]').prop('checked', checkedCount === totalCount);

                // Update global check all
                updateGlobalCheckAll();
            });

            function updateGlobalCheckAll() {
                var totalCheckboxes = $('.permission-checkbox').length;
                var checkedCheckboxes = $('.permission-checkbox:checked').length;

                $('#checkAll').prop('checked', checkedCheckboxes === totalCheckboxes);

                // Set indeterminate state if some but not all are checked
                $('#checkAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
            }

            // Initialize the state on page load
            updateGlobalCheckAll();
        });
    </script>
    @endsection


</x-dashboard.layout>
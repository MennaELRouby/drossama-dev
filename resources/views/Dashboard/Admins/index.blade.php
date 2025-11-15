<x-dashboard.layout :title="__('dashboard.admins')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.admins')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.admins') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons createUrl="{{ route('dashboard.admins.create') }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.name') }}</th>
                                    <th>{{ __('dashboard.email') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr id="{{ $admin->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $admin->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.admins.edit', $admin->id) }}">{{ $admin->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.admins.edit', $admin->id) }}">{{ $admin->name }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.admins.edit', $admin->id) }}">{{ $admin->email }}</a>
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
</x-dashboard.layout>

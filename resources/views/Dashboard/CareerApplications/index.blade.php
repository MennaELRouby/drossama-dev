<x-dashboard.layout :title="__('dashboard.career_applications')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.career_applications')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.career_applications') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">

                            <a id="btn_delete"><button class="btn ripple btn-danger"><i class="fas fa-trash"></i>
                                    {{ __('dashboard.delete') }}</button></a>
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
                                    <th> {{ __('dashboard.job_position') }}</th>
                                    <th>{{ __('dashboard.seen') }}</th>
                                    <th>{{ __('dashboard.download_cv') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($applications as $application)
                                    <tr id="{{ $application->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $application->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.career_applications.show', $application->id) }}">{{ $application->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.career_applications.show', $application->id) }}">{{ $application->name }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.career_applications.show', $application->id) }}">{{ $application->email }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.career_applications.show', $application->id) }}">{{ $application->jobPosition->title }}</a>
                                        </td>
                                        <td class="badge badge-soft-{{ $application->seen ? 'success' : 'warning' }}">
                                            {{ $application->seen ? __('dashboard.yes') : __('dashboard.no') }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.career_applications.download.cv', $application->id) }}"
                                                class="btn btn-link">
                                                <i class="fas fa-download"></i>
                                            </a>
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

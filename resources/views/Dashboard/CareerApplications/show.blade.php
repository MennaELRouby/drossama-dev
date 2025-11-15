<x-dashboard.layout :title="__('dashboard.career_applications')">
    <div class="container-fluid">


        <!-- Page Header -->
        <x-dashboard.partials.page-header :header="__('dashboard.application_form') . ' ' . $application->name" :label_url="route('dashboard.career_applications.index')" :label="__('dashboard.career_applications')" />
        <!-- End Page Header -->

        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 mb-0">{{ $application->name }}</h5>
                            </div>
                        </div>
                        <h4 class="font-size-16">{{ $application->email }}</h4>
                        <h4 class="font-size-16">{{ $application->phone }}</h4>
                        <h4 class="font-size-16">{{ $application->jobPosition->title }}</h4>
                        <p>{!! $application->cover_letter !!}</p>

                        <div class="row">
                            <div class="col-xl-2 col-6">
                                <div class="enhanced-page-header">{{ __('dashboard.download_cv') }}

                                    <div class="py-2 text-center">
                                        <a href="{{ route('dashboard.career_applications.download.cv', $application->id) }}"
                                            class="fw-medium">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <!-- end Col -->

        </div>
    </div>
</x-dashboard.layout>

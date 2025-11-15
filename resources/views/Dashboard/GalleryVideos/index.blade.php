<x-dashboard.layout :title="__('dashboard.gallery_videos')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.gallery_videos')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.gallery_videos') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">

                            <x-dashboard.partials.action-buttons
                                createUrl="{{ route('dashboard.gallery_videos.create') }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.title_en') }}</th>
                                    <th>{{ __('dashboard.title_ar') }}</th>
                                    <th>{{ __('dashboard.video') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($gallery_videos as $gallery_video)
                                    <tr id="{{ $gallery_video->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $gallery_video->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.gallery_videos.edit', $gallery_video->id) }}">{{ $gallery_video->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.gallery_videos.edit', $gallery_video->id) }}">{{ $gallery_video->title_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.gallery_videos.edit', $gallery_video->id) }}">{{ $gallery_video->title_ar }}</a>
                                        </td>
                                        <td>
                                            <div class="col-lg-4 col-12">
                                                <iframe width="100" height="150"
                                                    src="{{ $gallery_video->video_url }}" title="YouTube video player"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    referrerpolicy="strict-origin-when-cross-origin"
                                                    allowfullscreen></iframe>
                                            </div>

                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.gallery_videos.edit', $gallery_video->id) }}"
                                                class="status">
                                                @if ($gallery_video->status == 1)
                                                    {{ __('dashboard.yes') }}
                                                @else
                                                    {{ __('dashboard.no') }}
                                                @endif
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

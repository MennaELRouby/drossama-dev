<x-dashboard.layout :title="__('dashboard.add_testimonial')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_testimonial')" :label_url="route('dashboard.testimonials.index')" :label="__('dashboard.testimonials')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_testimonial') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.testimonials.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true" />
                            <x-dashboard.multilingual-input name="position" type="text" :required="true" />
                            <div class="form-group col-md-1">
                                <label>{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ old('order') }}"
                                    placeholder="{{ __('dashboard.order') }}">
                                @error('order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" form-group  col-md-3">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label class="">{{ __('dashboard.video_link') }}</label>
                                <input class="form-control" name="video_link" type="text"
                                    placeholder="مثال: dQw4w9WgXcQ أو https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                                    value="{{ old('video_link') }}">
                                <small class="text-muted">أدخل رابط يوتيوب كامل أو معرّف الفيديو فقط (11
                                    حرف/رقم)</small>
                            </div>

                            <!-- Multilingual Content -->
                            <x-dashboard.multilingual-input name="content" type="editor" rows="10" />


                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"
                                        checked />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.save') }} </button>
                                <a href="{{ route('dashboard.testimonials.index') }}"><button type="button"
                                        class="btn btn-danger mr-1"><i class="icon-trash"></i>
                                        {{ __('dashboard.cancel') }}</button></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->




</x-dashboard.layout>

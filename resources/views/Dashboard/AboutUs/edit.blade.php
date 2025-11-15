<x-dashboard.layout :title="__('dashboard.edit_about')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit_about')" :label_url="route('dashboard.home')" :label="__('dashboard.home')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit_about') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.about.update', [$about->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <x-dashboard.multilingual-input name="title" type="text" :required="true"
                                :model="$about" />

                            <x-dashboard.multilingual-input name="title2" type="text" :model="$about" />

                            <!-- Multilingual Short Description -->
                            <x-dashboard.multilingual-input name="short_desc" type="editor" rows="10"
                                :required="true" rows="4" :model="$about" />
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="text" type="editor" rows="10"
                                :model="$about" />


                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $about->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    placeholder="{{ __('dashboard.alt_image') }}" value="{{ $about->alt_image }}">
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.banner') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="banner">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.banner') }}</label>
                                <img src="{{ $about->banner_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_banner') }}</label>
                                <input class="form-control" name="alt_banner" type="text"
                                    placeholder="{{ __('dashboard.alt_banner') }}" value="{{ $about->alt_banner }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label class="">{{ __('dashboard.video_link') }}</label>
                                <input class="form-control" name="video_link" type="text"
                                    placeholder="مثال: dQw4w9WgXcQ أو https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                                    value="{{ $about->video_link }}">
                                <small class="text-muted">أدخل رابط يوتيوب كامل أو معرّف الفيديو فقط (11
                                    حرف/رقم)</small>
                            </div>


                            <div class="form-group col-md-12 mt-3">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.about.edit') }}"><button type="button"
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

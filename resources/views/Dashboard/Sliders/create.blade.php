<x-dashboard.layout :title="__('dashboard.add_slider')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_slider')" :label_url="route('dashboard.sliders.index')" :label="__('dashboard.sliders')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_slider') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="title" type="text" :required="true" />

                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="title2" type="text" :required="true" />

                            <div class="form-group col-md-4 mb-3">
                                <label for="type">{{ __('dashboard.type') }}</label>
                                <select name="type" class="form-control">
                                    <option value="">{{ __('dashboard.choose_type') }}</option>
                                    @foreach (App\Models\Slider::getTypeSelect() as $key => $label)
                                        <option value="{{ $key }}" @selected(old('type') === $key)>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="language">{{ __('dashboard.language') }}</label>
                                <select name="language" class="form-control">
                                    @foreach (App\Models\Slider::getLanguageSelect() as $key => $label)
                                        <option value="{{ $key }}" @selected(old('language', 'all') === $key)>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.desktop_image') }} (1920px * 1080px max 2mb)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.mobile_image') }} (768px * 1024px max 1mb) <small
                                        class="text-muted">({{ __('dashboard.optional') }})</small></label>
                                <input type="file" class="form-control" name="mobile_image" accept="image/*">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.alt_image') }}
                                    ({{ __('dashboard.desktop') }})</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.alt_image') }} ({{ __('dashboard.mobile') }})
                                    <small class="text-muted">({{ __('dashboard.optional') }})</small></label>
                                <input class="form-control" name="alt_mobile_image" type="text"
                                    value="{{ old('alt_mobile_image') }}"
                                    placeholder="{{ __('dashboard.alt_mobile_image') }}">
                            </div>

                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="text" type="editor" rows="10" />

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
                                <a href="{{ route('dashboard.sliders.index') }}"><button type="button"
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

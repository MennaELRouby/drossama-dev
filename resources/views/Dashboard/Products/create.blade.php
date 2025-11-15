<x-dashboard.layout :title="__('dashboard.add_product')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_product')" :label_url="route('dashboard.products.index')" :label="__('dashboard.products')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_product') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true" />

                            <div class="form-group col-md-2">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ old('order', 0) }}"
                                    placeholder="{{ __('dashboard.order') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="parent">{{ __('dashboard.parent') }}</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="" {{ !old('parent_id') ? 'selected' : '' }}>
                                        {{ __('dashboard.no_parent') }}</option>

                                    @foreach ($products as $productItem)
                                        <option @selected(old('parent_id') == $productItem->id) value="{{ $productItem->id }}">
                                            {{ $productItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" form-group  col-md-8">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-8">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">

                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    value="{{ old('alt_icon') }}" placeholder="{{ __('dashboard.alt_icon') }}">
                            </div>


                            <!-- Multilingual Short Description -->
                            <x-dashboard.multilingual-input name="short_desc" type="textarea" rows="4" />
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="10" />

                            <x-dashboard.multilingual-input name="clients" type="text" :required="false" />
                            <x-dashboard.multilingual-input name="location" type="text" :required="false" />



                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.category') }}</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">{{ __('dashboard.select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.service') }}</label>
                                <select class="form-control select2" name="service_id">
                                    <option value="">{{ __('dashboard.select_service') }}</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.date') }}</label>
                                <input class="form-control" name="date" type="date" value="{{ old('date') }}"
                                    placeholder="{{ __('dashboard.date') }}">
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" checked />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="show_in_home" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1"
                                            name="show_in_header" checked />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }} </h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1"
                                            name="show_in_footer" checked />
                                        <label for="switch4" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>

                            </div>



                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <h4 class="card-title">{{ __('dashboard.seo') }}</h4>
                                    </div>

                                    <x-dashboard.multilingual-input name="meta_title" type="textarea"
                                        :required="false" :rows="3" />
                                    <x-dashboard.multilingual-input name="meta_desc" type="textarea" :required="false"
                                        :rows="3" />


                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="index" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.save') }} </button>
                                <a href="{{ route('dashboard.products.index') }}"><button type="button"
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

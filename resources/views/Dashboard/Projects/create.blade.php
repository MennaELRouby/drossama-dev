<x-dashboard.layout :title="__('dashboard.add_project')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_project')" :label_url="route('dashboard.projects.index')" :label="__('dashboard.projects')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_project') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.name_en') }}</label>
                                <input class="form-control" name="name_en" type="text" value="{{ old('name_en') }}"
                                    placeholder="{{ __('dashboard.name_en') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.name_ar') }}</label>
                                <input class="form-control" name="name_ar" type="text" value="{{ old('name_ar') }}"
                                    placeholder="{{ __('dashboard.name_ar') }}">
                            </div>

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

                                    @foreach ($projects as $projectItem)
                                        <option @selected(old('parent_id') == $projectItem->id) value="{{ $projectItem->id }}">
                                            {{ $projectItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" form-group  col-md-8">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-8">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon" accept="image/*">

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
                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.clients_en') }}</label>
                                <input class="form-control" name="clients_en" type="text"
                                    value="{{ old('clients_en') }}" placeholder="{{ __('dashboard.clients_en') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.location_en') }}</label>
                                <input class="form-control" name="location_en" type="text"
                                    value="{{ old('location_en') }}" placeholder="{{ __('dashboard.location_en') }}">
                            </div>



                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.category_en') }}</label>
                                <input class="form-control" name="category_en" type="text"
                                    value="{{ old('category_en') }}"
                                    placeholder="{{ __('dashboard.category_en') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.service_en') }}</label>
                                <input class="form-control" name="service_en" type="text"
                                    value="{{ old('service_en') }}" placeholder="{{ __('dashboard.service_en') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.clients_ar') }}</label>
                                <input class="form-control" name="clients_ar" type="text"
                                    value="{{ old('clients_ar') }}" placeholder="{{ __('dashboard.clients_ar') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.location_ar') }}</label>
                                <input class="form-control" name="location_ar" type="text"
                                    value="{{ old('location_ar') }}"
                                    placeholder="{{ __('dashboard.location_ar') }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.category_ar') }}</label>
                                <input class="form-control" name="category_ar" type="text"
                                    value="{{ old('category_ar') }}"
                                    placeholder="{{ __('dashboard.category_ar') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.service_ar') }}</label>
                                <input class="form-control" name="service_ar" type="text"
                                    value="{{ old('service_ar') }}" placeholder="{{ __('dashboard.service_ar') }}">
                            </div>

                            <div class="form-group col-md-4"></div>
                            <label class="">{{ __('dashboard.date') }}</label>
                            <input class="form-control" name="date" type="date" value="{{ old('date') }}"
                                placeholder="{{ __('dashboard.date') }}">
                        </div>
                        <br>
                        <hr>
                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <select class="form-control" data-trigger name="category_id" required>
                                        <option value="" {{ !old('category_id') ? 'selected' : '' }}>
                                            {{ __('dashboard.select_category') }}</option>
                                        @foreach ($categories as $category)
                                            @if ($category->parent_id == null)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

                                <div class="form-group col-md-5">
                                    <label> {{ __('dashboard.meta_title_en') }}</label>
                                    <textarea class="form-control" name="meta_title_en" placeholder="{{ __('dashboard.meta_title_en') }}"> {!! old('meta_title_en') !!}</textarea>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="meta_desc"> {{ __('dashboard.meta_desc_en') }}</label>
                                    <textarea class="form-control" name="meta_desc_en" placeholder="{{ __('dashboard.meta_desc_en') }}">{!! old('meta_desc_en') !!}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <hr>

                                </div>


                                <div class="form-group col-md-5">
                                    <label> {{ __('dashboard.meta_title_ar') }}</label>
                                    <textarea class="form-control" name="meta_title_ar" placeholder="{!! __('dashboard.meta_title_ar') !!}"></textarea>
                                </div>

                                <div class="form-group col-md-5">
                                    <label> {{ __('dashboard.meta_desc_ar') }}</label>
                                    <textarea class="form-control" name="meta_desc_ar" placeholder="{!! __('dashboard.meta_desc') !!}"></textarea>
                                </div>


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
                            <a href="{{ route('dashboard.projects.index') }}"><button type="button"
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

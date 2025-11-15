<x-dashboard.layout :title="__('dashboard.add_page')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_page')" :label_url="route('dashboard.pages.index')" :label="__('dashboard.pages')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_page') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.pages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.title_en') }}</label>
                                <input class="form-control" name="title_en" type="text" value="{{ old('title_en') }}"
                                    placeholder="{{ __('dashboard.title_en') }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.title_ar') }}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{ old('title_ar') }}"
                                    placeholder="{{ __('dashboard.title_ar') }}" required>
                            </div>



                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.content_en') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="content_en" type="text"
                                    placeholder="{{ __('dashboard.content_en') }}">{!! old('content_en') !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.content_ar') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="content_ar" type="text"
                                    placeholder="{{ __('dashboard.content_ar') }}">{!! old('content_ar') !!}</textarea>
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
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.save') }} </button>
                                <a href="{{ route('dashboard.pages.index') }}"><button type="button"
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

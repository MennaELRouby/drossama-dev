<x-dashboard.layout :title="__('dashboard.add_album')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_album')" :label_url="route('dashboard.albums.index')" :label="__('dashboard.albums')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_album') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.albums.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" value="{{old('name_en')}}" placeholder="{{__('dashboard.name_en')}}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" value="{{old('name_ar')}}" placeholder="{{__('dashboard.name_ar')}}" >
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{__('dashboard.order')}}</label>
                                <input class="form-control" name="order" type="number" value="{{old('order')}}" placeholder="{{__('dashboard.order')}}" >
                            </div>



                            <div class=" form-group  col-md-8">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            
                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_en')}}</label>
                                <textarea class="form-control" name="short_desc_en" type="text" placeholder="{{__('dashboard.short_desc_en')}}">{!! old('short_desc_en') !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_ar')}}</label>
                                <textarea class="form-control" name="short_desc_ar" type="text" placeholder="{{__('dashboard.short_desc_ar')}}">{!! old('short_desc_ar') !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_desc_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_en" type="text" placeholder="{{__('dashboard.long_desc_en')}}">{!! old('long_desc_en') !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_desc_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_ar" type="text" placeholder="{{__('dashboard.long_desc_ar')}}">{!! old('long_desc_ar') !!}</textarea>
                            </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label class="">{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                    </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1" name="status" checked />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1" name="show_in_home" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1" name="show_in_header" checked />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }} </h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1" name="show_in_footer" checked />
                                        <label for="switch4" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
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
                                        <label> {{__('dashboard.meta_title_en')}}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{__('dashboard.meta_title_en')}}"> {!! old('meta_title_en') !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{__('dashboard.meta_desc_en')}}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{__('dashboard.meta_desc_en')}}">{!! old('meta_desc_en') !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>

                                    </div>


                                    <div class="form-group col-md-5">
                                        <label> {{__('dashboard.meta_title_ar')}}</label>
                                        <textarea class="form-control" name="meta_title_ar" placeholder="{!!__('dashboard.meta_title_ar')!!}"></textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{__('dashboard.meta_desc_ar')}}</label>
                                        <textarea class="form-control" name="meta_desc_ar" placeholder="{!! __('dashboard.meta_desc') !!}"></textarea>
                                    </div>


                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <h5 class="font-size-14 mb-3">{{__('dashboard.meta_robots')}} (index)</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1" name="index" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.products.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
                                        {{__('dashboard.cancel')}}</button></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
</x-dashboard.layout>

<x-dashboard.layout :title="__('dashboard.add_domain')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_domain')" :label_url="route('dashboard.domains.index')" :label="__('dashboard.domains')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_domain') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.domains.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_en')}}</label>
                                <input class="form-control" name="title_en" type="text" value="{{old('title_en')}}" placeholder="{{__('dashboard.title_en')}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_ar')}}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar')}}" placeholder="{{__('dashboard.title_ar')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.yearly_price')}}</label>
                                <input class="form-control" name="yearly_price" type="text" value="{{old('yearly_price')}}" placeholder="{{__('dashboard.yearly_price')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.transfer_price')}}</label>
                                <input class="form-control" name="transfer_price" type="text" value="{{old('transfer_price')}}" placeholder="{{__('dashboard.transfer_price')}}">
                            </div>
                            

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.renewal_price')}}</label>
                                <input class="form-control" name="renewal_price" type="text" value="{{old('renewal_price')}}" placeholder="{{__('dashboard.renewal_price')}}">
                            </div>
                            

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_en')}}</label>
                                <textarea class="form-control" name="short_desc_en" type="text" placeholder="{{__('dashboard.short_desc_en')}}">{!! old('short_desc_en') !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_ar')}}</label>
                                <textarea class="form-control" name="short_desc_ar" type="text" placeholder="{{__('dashboard.short_desc_ar')}}">{!! old('short_desc_ar') !!}</textarea>
                            </div>
                          

                            <div class="form-group col-md-4 mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status" checked />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
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
                                <a href="{{route('dashboard.domains.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

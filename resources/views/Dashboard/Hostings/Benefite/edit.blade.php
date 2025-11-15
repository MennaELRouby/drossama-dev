<x-dashboard.layout :title="__('dashboard.edit') . $benefit->title">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit').$benefit->title" :label_url="route('dashboard.benefits.index')" :label="__('dashboard.benefits')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit').$benefit->title }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.hostings.benefits.update',[$hosting->id,$benefit->id]) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.title_en')}}</label>
                                <input class="form-control" name="title_en" type="text" value="{{old('title_en', $benefit->title_en)}}" >
                            </div>

                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.title_ar')}}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar', $benefit->title_ar)}}"  >
                            </div>


                            <div class="form-group col-md-2">
                                <label class="">{{__('dashboard.order')}}</label>
                                <input class="form-control" name="order" type="number" value="{{old('order', $benefit->order)}}"  >
                            </div>



                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $benefit->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{__('dashboard.alt_image')}}</label>
                                <input class="form-control" name="alt_image" type="text" value="{{old('alt_image',$benefit->alt_image)}}" >
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.icon')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $benefit->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{__('dashboard.alt_icon')}}</label>
                                <input class="form-control" name="alt_icon" type="text" value="{{old('alt_icon',$benefit->alt_icon)}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_description_en')}}</label>
                                <textarea class="form-control"  name="short_description_en" type="text" >{!! old('short_description_en',$benefit->short_description_en) !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_description_ar')}}</label>
                                <textarea class="form-control" name="short_description_ar" type="text" >{!! old('short_description_ar',$benefit->short_description_ar) !!}</textarea>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_description_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_description_en" type="text" >{!! old('long_description_en',$benefit->long_description_en) !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_description_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_description_ar" type="text" >{!! old('long_description_ar',$benefit->long_description_ar) !!}</textarea>
                            </div>

                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"  @checked(old('status', $benefit->status)) />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.benefits.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

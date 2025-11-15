<x-dashboard.layout :title="__('dashboard.edit') . $hosting->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit').$hosting->name" :label_url="route('dashboard.hostings.index')" :label="__('dashboard.hostings')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.edit').$hosting->name }}</h4>

                    <div class="btn btn-list">
                        <a href="{{ route('dashboard.hostings.benefits.index',$hosting->id) }}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i>
                                {{__('dashboard.benefits')}}</button></a>
                        <a href="{{ route('dashboard.hostings.faqs.index',$hosting->id) }}"><button class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i>
                                    {{__('dashboard.faqs')}}</button>
                        </a>
    
                    </div>
                  
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.hostings.update',[$hosting->id]) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" value="{{$hosting->name_en}}" placeholder="{{__('dashboard.name_en')}}" >
                            </div>

                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" value="{{$hosting->name_ar}}" placeholder="{{__('dashboard.name_ar')}}" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="parent">{{__('dashboard.parent')}}</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="{{ $hosting->parent_id ?? '' }}" >{{$hosting->parent_name}}</option>

                                    @foreach($hostings as $hostingItem)
                                    <option @selected(old('parent_id')==$hostingItem->id ) value="{{$hostingItem->id}}">{{
                                        $hostingItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $hosting->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.alt_image')}}</label>
                                <input class="form-control" name="alt_image" type="text" placeholder="{{__('dashboard.alt_image')}}" value="{{ $hosting->alt_image }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('dashboard.icon')}} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon" >

                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icon') }}</label>
                                <img src="{{ $hosting->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.alt_icon')}}</label>
                                <input class="form-control" name="alt_icon" type="text" placeholder="{{__('dashboard.alt_icon')}}" value="{{ $hosting->alt_icon }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_en')}}</label>
                                <textarea class="form-control" name="short_desc_en" type="text" placeholder="{{__('dashboard.short_desc_en')}}">{!!$hosting->short_desc_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.short_desc_ar')}}</label>
                                <textarea class="form-control" name="short_desc_ar" type="text" placeholder="{{__('dashboard.short_desc_ar')}}">{!!$hosting->short_desc_ar !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_desc_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_en" type="text" placeholder="{{__('dashboard.long_desc_en')}}">{!!$hosting->long_desc_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.long_desc_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_ar" type="text" placeholder="{{__('dashboard.long_desc_ar')}}">{!!$hosting->long_desc_ar !!}</textarea>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1" name="status"  @checked(old('status', $hosting->status)) />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1" name="show_in_home" @checked(old('show_in_home', $hosting->show_in_home))  />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1" name="show_in_header" @checked(old('show_in_header', $hosting->show_in_header)) />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                               
                                
                            </div>




                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <h4 class="card-title">{{ __('dashboard.seo') }}</h4>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="name_ar">{{__('dashboard.slug_en')}}</label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="{{__('dashboard.slug_en')}}" name="slug_en" value="{{ $hosting->slug_en }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{__('dashboard.meta_title_en')}}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{__('dashboard.meta_title_en')}}"> {!!  $hosting->meta_title_en !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{__('dashboard.meta_desc_en')}}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{__('dashboard.meta_desc_en')}}"> {!!  $hosting->meta_desc_en !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>

                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>{{__('dashboard.slug_ar')}}</label>
                                        <input type="text" autocomplete="off" class="form-control" placeholder="{{__('dashboard.slug_ar')}}" name="slug_ar" value="{{ $hosting->slug_ar }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{__('dashboard.meta_title_ar')}}</label>
                                        <textarea class="form-control" name="meta_title_ar" placeholder="{!!__('dashboard.meta_title_ar')!!}">{{  $hosting->meta_title_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{__('dashboard.meta_desc_ar')}}</label>
                                        <textarea class="form-control" name="meta_desc_ar" placeholder="{!! __('dashboard.meta_desc') !!}">{!!  $hosting->meta_desc_ar !!}</textarea>
                                    </div>


                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{__('dashboard.meta_robots')}} (index)</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1" name="index"  @checked(old('index', $hosting->index)) />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.update')}} </button>
                                <a href="{{route('dashboard.hostings.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

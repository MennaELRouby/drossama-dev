<x-dashboard.layout :title="__('dashboard.edit') . $gallery_video->title">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit').$gallery_video->title" :label_url="route('dashboard.gallery_videos.index')" :label="__('dashboard.gallery_videos')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit').$gallery_video->title }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.gallery_videos.update',[$gallery_video->id]) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_en')}}</label>
                                <input class="form-control" name="title_en" type="text" value="{{$gallery_video->title_en}}" placeholder="{{__('dashboard.title_en')}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_ar')}}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{$gallery_video->title_ar}}" placeholder="{{__('dashboard.title_ar')}}" >
                            </div>


                           <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.video_url')}}</label>
                                <input class="form-control" name="video_url" type="text" value="{{$gallery_video->video_url}}" placeholder="{{__('dashboard.video_url')}}" >
                            </div>

                            <div class="col-lg-4 col-12">
                                <iframe width="560" height="315" src="{{ $gallery_video->video_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $gallery_video->image_path }}" width="250">
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.icon')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icon') }}</label>
                                <img src="{{ $gallery_video->icon_path }}" width="250">
                            </div>

                           <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.description_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="description_en" type="text" placeholder="{{__('dashboard.description_en')}}">{!! old('description_en' , $gallery_video->description_en) !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.description_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="description_ar" type="text" placeholder="{{__('dashboard.description_ar')}}">{!! old('description_ar' , $gallery_video->description_ar) !!}</textarea>
                            </div>


                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"  @checked(old('status', $gallery_video->status)) />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.update')}} </button>
                                <a href="{{route('dashboard.sliders.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

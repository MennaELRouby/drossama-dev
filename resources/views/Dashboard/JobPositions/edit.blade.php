<x-dashboard.layout :title="__('dashboard.edit') . $job_position->title">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit').$job_position->title" :label_url="route('dashboard.job_positions.index')" :label="__('dashboard.job_positions')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit').$job_position->title }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.job_positions.update',[$job_position->id]) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_en')}}</label>
                                <input class="form-control" name="title_en" type="text" value="{{old('title_en') ?? $job_position->title_en}}" placeholder="{{__('dashboard.title_en')}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.title_ar')}}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar') ?? $job_position->title_ar}}" placeholder="{{__('dashboard.title_ar')}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.description_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="description_en" type="text" placeholder="{{__('dashboard.description_en')}}">{!! old('description_en')  ?? $job_position->description_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.description_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="description_ar" type="text" placeholder="{{__('dashboard.description_ar')}}">{!! old('description_ar') ?? $job_position->description_ar!!}</textarea>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.location')}}</label>
                                <input class="form-control" name="location" type="text" value="{{old('location') ?? $job_position->location}}" placeholder="{{__('dashboard.location')}}" >
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="type">{{ __('dashboard.type') }}</label>
                                <select name="type" class="form-control">
                                    <option value="">{{ __('dashboard.choose_type') }}</option>
                                    @foreach (App\Models\JobPosition::getTypeSelect() as $key =>$label )
                                    <option value="{{ $key }}" @selected((old('type', $job_position->type ?? '') == $key))>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.image')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $job_position->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.alt_image')}}</label>
                                <input class="form-control" name="alt_image" type="text" placeholder="{{__('dashboard.alt_image')}}" value="{{ $job_position->alt_image }}">
                            </div>


                            <div class=" form-group  col-md-6">
                                <label>{{__('dashboard.icon')}} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icon') }}</label>
                                <img src="{{ $job_position->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.alt_icon')}}</label>
                                <input class="form-control" name="alt_icon" type="text" placeholder="{{__('dashboard.alt_icon')}}" value="{{ $job_position->alt_icon }}">
                            </div>


                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"  @checked(old('status', $job_position->status)) />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.update')}} </button>
                                <a href="{{route('dashboard.job_positions.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

<x-dashboard.layout :title="__('dashboard.add_attribute')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_attribute')" :label_url="route('dashboard.attributes.index')" :label="__('dashboard.attributes')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_attribute') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.attributes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.name_en')}}</label>
                                <input class="form-control" name="name_en" type="text" value="{{old('name_en')}}" placeholder="{{__('dashboard.name_en')}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.name_ar')}}</label>
                                <input class="form-control" name="name_ar" type="text" value="{{old('name_ar')}}" placeholder="{{__('dashboard.name_ar')}}" >
                            </div>

                            <div class="form-group col-md-8">
                                <label>{{__('dashboard.icon')}} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">

                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.alt_icon')}}</label>
                                <input class="form-control" name="alt_icon" type="text" value="{{old('alt_icon')}}" placeholder="{{__('dashboard.alt_icon')}}">
                            </div>


                            <div class="form-group col-md-4">
                                <div class="d-flex flex-wrap gap-2">

                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>

                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status" checked />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.attributes.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

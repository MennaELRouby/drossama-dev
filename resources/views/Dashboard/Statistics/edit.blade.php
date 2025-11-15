<x-dashboard.layout :title="__('dashboard.edit') . $statistic->title">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit').$statistic->title" :label_url="route('dashboard.statistics.index')" :label="__('dashboard.statistics')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit').$statistic->title }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.statistics.update',[$statistic->id]) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.title_en')}}</label>
                                <input class="form-control" name="title_en" type="text" value="{{old('title_en') ?? $statistic->title_en}}" placeholder="{{__('dashboard.title_en')}}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.title_ar')}}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar') ?? $statistic->title_ar}}" placeholder="{{__('dashboard.title_ar')}}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.value')}}</label>
                                <input class="form-control" name="value" type="number" value="{{old('value') ?? $statistic->value}}" placeholder="{{__('dashboard.value')}}" >
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.text_en')}}</label>
                                <textarea class="form-control"  name="text_en" type="text" placeholder="{{__('dashboard.text_en')}}">{!! old('text_en') ?? $statistic->text_en!!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.text_ar')}}</label>
                                <textarea class="form-control" name="text_ar" type="text" placeholder="{{__('dashboard.text_ar')}}">{!! old('text_ar') ?? $statistic->text_ar !!}</textarea>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                <input type="checkbox" id="switch1" switch="none" value="1" name="status"  @checked(old('status', $statistic->status)) />
                                <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.statistics.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

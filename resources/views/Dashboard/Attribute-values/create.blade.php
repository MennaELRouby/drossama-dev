
<x-dashboard.layout :title="$attribute->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_attribute_values')" :label_url=" route('dashboard.attributes.edit',[$attribute->id]) " :label="$attribute->name" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ $attribute->name}}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.attributes.values.store',[$attribute->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.value_en')}}</label>
                                <input class="form-control" name="value_en" type="text" value="{{old('value_en')}}" placeholder="{{__('dashboard.value_en')}}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.value_ar')}}</label>
                                <input class="form-control" name="value_ar" type="text" value="{{old('value_ar')}}" placeholder="{{__('dashboard.value_ar')}}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{__('dashboard.price')}}</label>
                                <input class="form-control" name="price" type="text" value="{{old('price')}}" placeholder="{{__('dashboard.price')}}" >
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
                                    {{ __('Save changes') }} </button>
                                <a href="{{ route('dashboard.attributes.edit',[$attribute->id]) }}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

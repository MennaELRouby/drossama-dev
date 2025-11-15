<x-dashboard.layout :title="__('dashboard.add_attribute_values')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_attribute_values')" :label_url="route('dashboard.plans.index')" :label="__('dashboard.add_attribute_values')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_attribute_values') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.plans.storeAttributeValues',[$plan->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           
                            @foreach ($plan->planAttributes as $planAttribute)
                                <div class="form-group mt-4 col-md-4">
                                        <label for="">{{ $planAttribute->attribute->name }}</label>
                                        <select class="form-control select2-multiple" name="attribute_values[{{ $planAttribute->attribute->id }}][]" multiple>
                                            @foreach ( $planAttribute->attribute->values as $value)
                                                <option value="{{ $value->id }}" 
                                                    {{ in_array($value->id, $plan->attributeValues->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $value->value_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                </div>
                            @endforeach


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.plans.index')}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
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

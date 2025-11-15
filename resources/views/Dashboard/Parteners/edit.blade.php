<x-dashboard.layout :title="__('dashboard.edit') . $partener->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . $partener->name" :label_url="route('dashboard.parteners.index')" :label="__('dashboard.parteners')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.edit') . $partener->name }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.parteners.update', [$partener->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-5">
                                <label class="">{{ __('dashboard.name_en') }}</label>
                                <input class="form-control" name="name_en" type="text"
                                    value="{{ $partener->name_en }}" placeholder="{{ __('dashboard.name_en') }}">
                            </div>

                            <div class="form-group col-md-5">
                                <label class="">{{ __('dashboard.name_ar') }}</label>
                                <input class="form-control" name="name_ar" type="text"
                                    value="{{ $partener->name_ar }}" placeholder="{{ __('dashboard.name_ar') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ $partener->order }}"
                                    placeholder="{{ __('dashboard.order') }}">
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.logo') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="logo">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.logo') }}</label>
                                <img src="{{ $partener->logo_path }}" width="250">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('dashboard.products') }}</label>
                                <select class="form-control select2" name="products[]" multiple="multiple">
                                    @foreach (\App\Models\Product::orderBy('order')->get() as $product)
                                        <option value="{{ $product->id }}"
                                            @if ($partener->products->contains($product->id)) selected @endif>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small
                                    class="form-text text-muted">{{ __('dashboard.select_products_for_partner') }}</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.description_en') }}</label>
                                <textarea class="form-control" name="description_en" type="text" placeholder="{{ __('dashboard.description_en') }}">{!! $partener->description_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.description_ar') }}</label>
                                <textarea class="form-control" name="description_ar" type="text" placeholder="{{ __('dashboard.description_ar') }}">{!! $partener->description_ar !!}</textarea>
                            </div>


                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" @checked(old('status', $partener->status)) />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.parteners.index') }}"><button type="button"
                                        class="btn btn-danger mr-1"><i class="icon-trash"></i>
                                        {{ __('dashboard.cancel') }}</button></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->




</x-dashboard.layout>

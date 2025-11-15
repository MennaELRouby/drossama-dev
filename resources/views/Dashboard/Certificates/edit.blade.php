<x-dashboard.layout :title="__('dashboard.edit') . ' ' . $certificate->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . ' ' . $certificate->name" :label_url="route('dashboard.certificates.index')" :label="__('dashboard.certificates')" />
    <!-- End Page Header -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit') . ' ' . $certificate->name }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.certificates.update', [$certificate->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true"
                                :model="$certificate" />

                            <!-- Order -->
                            <div class="form-group col-md-1">
                                <label>{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number"
                                    value="{{ old('order', $certificate->order) }}"
                                    placeholder="{{ __('dashboard.order') }}">
                                @error('order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- End Order -->

                            <div class=" form-group  col-md-3">
                                <label>{{ __('dashboard.image') }} (800px * 600px max 2mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-4 mt-3">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $certificate->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image', $certificate->alt_image) }}">
                            </div>

                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"
                                        @checked(old('status', $certificate->status)) />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.certificates.index') }}"><button type="button"
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

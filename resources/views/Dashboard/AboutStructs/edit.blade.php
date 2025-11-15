<x-dashboard.layout :title="__('dashboard.edit') . ($about_struct->name ?? '')">
    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . ($about_struct->name ?? '')" :label_url="route('dashboard.about-structs.index')" :label="__('dashboard.about-structs')" />
    <!-- End Page Header -->
    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ __('dashboard.edit') . ($about_struct->name ?? '') }}
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.about-structs.update', [$about_struct->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <x-dashboard.multilingual-input name="name" type="text" :required="true"
                                :model="$about_struct" />

                            <div class="form-group col-md-2">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number"
                                    value="{{ $about_struct->order }}">
                            </div>


                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.icon') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icon') }}</label>
                                <img src="{{ $about_struct->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    placeholder="{{ __('dashboard.alt_icon') }}" value="{{ $about_struct->alt_icon }}">
                            </div>
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="10"
                                :model="$about_struct" />

                            <div class="form-group col-md-4 mt-3 mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" id="status_switch" switch="none" value="1"
                                        name="status" @checked(old('status', $about_struct->status)) />
                                    <label for="status_switch" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.about-structs.index') }}"><button type="button"
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

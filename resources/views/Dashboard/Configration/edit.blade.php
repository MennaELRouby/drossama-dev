<x-dashboard.layout :title="__('dashboard.edit_configration')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit_configration')" :label_url="route('dashboard.home')" :label="__('dashboard.home')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit_configration') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.configrations.update', $lang) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="form-group col-md-12 ">
                                <fieldset class="form-group">
                                    <label for="title_en">{{ __('dashboard.site_name') }}</label>
                                    <input type="text" class="form-control" name="site_name"
                                        value="{{ $configrations['site_name'] }}">
                                </fieldset>
                            </div>



                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.site_description') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="site_description" type="text">{!! $configrations['site_description'] !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.site_footer_text') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="site_footer_text" type="text">{!! $configrations['site_footer_text'] !!}</textarea>
                            </div>



                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.site_logo') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="site_logo">
                            </div>


                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.site_logo') }}</label>
                                @if (
                                    $configrations['site_logo'] &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists('configurations/' . $configrations['site_logo']))
                                    <img src="{{ asset('storage/configurations/' . $configrations['site_logo']) }}"
                                        width="250" alt="Site Logo">
                                @else
                                    <img src="{{ asset('assets/dashboard/images/noimage.png') }}" width="250"
                                        alt="No Logo">
                                @endif
                            </div>



                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.site_footer_logo') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="site_footer_logo">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.site_footer_logo') }}</label>
                                @if (
                                    $configrations['site_footer_logo'] &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                            'configurations/' . $configrations['site_footer_logo']))
                                    <img src="{{ asset('storage/configurations/' . $configrations['site_footer_logo']) }}"
                                        width="250" alt="Footer Logo">
                                @else
                                    <img src="{{ asset('assets/dashboard/images/noimage.png') }}" width="250"
                                        alt="No Footer Logo">
                                @endif
                            </div>



                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.site_favicon') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="site_favicon">
                            </div>
                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.site_favicon') }}</label>
                                @if (
                                    $configrations['site_favicon'] &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists('configurations/' . $configrations['site_favicon']))
                                    <img src="{{ asset('storage/configurations/' . $configrations['site_favicon']) }}"
                                        width="250" alt="Favicon">
                                @else
                                    <img src="{{ asset('assets/dashboard/images/noimage.png') }}" width="250"
                                        alt="No Favicon">
                                @endif
                            </div>



                            <div class="form-group col-md-12">
                                <label class="">{{ __('dashboard.site_copyright') }}</label>
                                <textarea class="form-control" name="site_copyright" type="text">{!! $configrations['site_copyright'] !!}</textarea>
                            </div>



                            <div class="form-group col-md-12 mt-3">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.configrations.edit', 'ar') }}"><button type="button"
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

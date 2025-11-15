<x-dashboard.layout :title="__('dashboard.edit') . $category->name">



    @section('style')
        <style>
            img {
                display: block !important;
            }

            .dz-hidden-input {
                position: absolute !important;
                top: 0px !important;
                left: 250px !important;
            }
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    @endsection
    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . $category->name" :label_url="route('dashboard.categories.index')" :label="__('dashboard.categories')" />
    <!-- End Page Header -->
    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.edit') . $category->name }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.categories.update', [$category->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true"
                                :model="$category" />

                            <div class="form-group col-md-2">
                                <label>{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ $category->order }}"
                                    placeholder="{{ __('dashboard.order') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="parent">{{ __('dashboard.parent') }}</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="{{ $category->parent_id }}">
                                        {{ $category->parent->name ?? __('dashboard.no_parent') }}</option>
                                    </option>

                                    @foreach ($categories as $categoryItem)
                                        <option @selected(old('parent_id') == $categoryItem->id) value="{{ $categoryItem->id }}">
                                            {{ $categoryItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $category->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    placeholder="{{ __('dashboard.alt_image') }}" value="{{ $category->alt_image }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">

                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icon') }}</label>
                                <img src="{{ $category->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    placeholder="{{ __('dashboard.alt_icon') }}" value="{{ $category->alt_icon }}">
                            </div>


                            <!-- Multilingual Short Description -->
                            <x-dashboard.multilingual-input name="short_desc" type="textarea" rows="4"
                                :model="$category" />
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="10"
                                :model="$category" />

                            <div class="form-group col-md-12">
                                <hr>
                                <label for="service_images">{{ trans('home.service_images') }}</label>
                                <input type="file" class="form-control" name="service_images[]" multiple
                                    accept="image/*">
                            </div>
                            @if (!empty($category->images) && $category->images->count() > 0)
                                <a href='#' data-id="{{ $category->id }}"
                                    class='delete_all_img btn btn-danger mt-2 col-4'>{{ trans('home.delete_all') }}</a>

                                <div class="col-md-12 mt-3">
                                    <div id="" class="row mb-0">
                                        @foreach ($category->images as $key => $image)
                                            <div class="col-xs-6 col-sm-2 col-md-2 col-xl-2 mb-2 pl-sm-2 pr-sm-2"
                                                data-responsive="{{ $image->image_url }}"
                                                data-src="{{ $image->image_url }}"
                                                data-sub-html="<h4> {{ trans('home.image') }} {{ $key + 1 }}</h4>">
                                                <a href="javascript:;">
                                                    <img class="img-responsive" src="{{ $image->image_url }}"
                                                        width="150px" height="150px">
                                                </a>
                                                <div>

                                                    <br>
                                                    <a href='#' data-image='{{ $image->id }}'
                                                        class='delete_img_btn btn btn-danger'>{{ trans('dashboard.delete') }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" @checked(old('status', $category->status)) />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="show_in_home" @checked(old('show_in_home', $category->show_in_home)) />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1"
                                            name="show_in_header" @checked(old('show_in_header', $category->show_in_header)) />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }} </h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1"
                                            name="show_in_footer" @checked(old('show_in_footer', $category->show_in_footer)) />
                                        <label for="switch4" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <h4 class="card-title">{{ __('dashboard.seo') }}</h4>
                                    </div>
                                    <x-dashboard.multilingual-input name="slug" type="text" :required="false"
                                        :model="$category" />
                                    <x-dashboard.multilingual-input name="meta_title" type="textarea"
                                        :required="false" :rows="3" :model="$category" />
                                    <x-dashboard.multilingual-input name="meta_desc" type="textarea"
                                        :required="false" :rows="3" :model="$category" />
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)</h5>
                                        <input type="checkbox" id="switch5" switch="none" value="1"
                                            name="index" @checked(old('index', $category->index)) />
                                        <label for="switch5" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.categories.index') }}"><button type="button"
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
    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>

        <script type="text/javascript">
            var token = "{{ csrf_token() }}";
            Dropzone.autoDiscover = false;

            $("div.upload_images").dropzone({
                addRemoveLinks: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg.webp",
                maxFilesize: 3, // MB
                url: "{{ route('dashboard.categories.uploadImages') }}",

                init: function() {
                    this.on("sending", function(file, xhr, formData) {
                        formData.append("categoryId", "{{ $category->id }}");
                    });
                },

                params: {
                    _token: token,
                    type: 'category_image',
                },

                removedfile: function(file) {
                    var fileName = file.name;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('dashboard.categories.removeUploadImages') }}", // استخدم route بدلاً من URL::to
                        data: {
                            type: 'category_image',
                            name: fileName,
                            request: 'delete'
                        },
                        success: function(data) {
                            console.log('success: ' + data);
                        }
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) :
                        void 0;
                }
            });

            Dropzone.options.myAwesomeDropzone = {
                paramName: "file",
                maxFilesize: 3, // MB
                accept: function(file, done) {
                    done();
                }
            };

            $('.delete_img_btn').on('click', function() {
                var image = $(this).data('image');
                var categoryId = "{{ $category->id }}";
                var btn = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('dashboard.categories.deleteImage', $category->id) }}",
                    method: 'POST',
                    data: {
                        image: image,
                        categoryId: categoryId
                    },
                    success: function(data) {
                        location.href = "{{ route('dashboard.categories.edit', $category->id) }}";
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @endsection
</x-dashboard.layout>

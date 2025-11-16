<x-dashboard.layout :title="__('dashboard.edit') . $album->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . $album->name" :label_url="route('dashboard.albums.index')" :label="__('dashboard.albums')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.edit') . $album->name }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.albums.update', [$album->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.name_en') }}</label>
                                <input class="form-control" name="name_en" type="text" value="{{ $album->name_en }}"
                                    placeholder="{{ __('dashboard.name_en') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.name_ar') }}</label>
                                <input class="form-control" name="name_ar" type="text" value="{{ $album->name_ar }}"
                                    placeholder="{{ __('dashboard.name_ar') }}">
                            </div>


                            <div class="form-group col-md-2">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ $album->order }}"
                                    placeholder="{{ __('dashboard.order') }}">
                            </div>


                            <div class=" form-group  col-md-6">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.image') }}</label>
                                <img src="{{ $album->image_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    placeholder="{{ __('dashboard.alt_image') }}" value="{{ $album->alt_image }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.icon') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">

                            </div>

                            <div class=" form-group  col-md-2">
                                <label for="">{{ __('dashboard.icoon') }}</label>
                                <img src="{{ $album->icon_path }}" width="250">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    placeholder="{{ __('dashboard.alt_image') }}" value="{{ $album->alt_image }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.short_desc_en') }}</label>
                                <textarea class="form-control" name="short_desc_en" type="text" placeholder="{{ __('dashboard.short_desc_en') }}">{!! $album->short_desc_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.short_desc_ar') }}</label>
                                <textarea class="form-control" name="short_desc_ar" type="text" placeholder="{{ __('dashboard.short_desc_ar') }}">{!! $album->short_desc_ar !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.long_desc_en') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_en" type="text"
                                    placeholder="{{ __('dashboard.long_desc_en') }}">{!! $album->long_desc_en !!}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.long_desc_ar') }}</label>
                                <textarea class="form-control" id="myeditorinstance" name="long_desc_ar" type="text"
                                    placeholder="{{ __('dashboard.long_desc_ar') }}">{!! $album->long_desc_ar !!}</textarea>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-10">
                                    <h6 class="card-title mb-1">
                                        {{ trans('home.edit_album') }}
                                        <span class="badge badge-warning">
                                            {{ trans('home.changing album will change specifications values') }}
                                        </span>
                                    </h6>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#Modal1">
                                        <i class="fas fa-edit" style="color:black"></i>
                                    </a>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <select class="form-control select2" name="album_id" id="album_id">
                                            <option value="{{ $album->album_id }}">
                                                {{ $album->album ? (app()->getLocale() == 'en' ? $album->album->name_en : $album->album->name_ar) : '' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                                <label for="album_images">{{ __('dashboard.album_images') }}</label>
                                <input type="file" class="form-control" name="album_images[]" multiple
                                    accept="image/*">
                            </div>
                            <br>
                            <hr>
                            <br>
                            @if (!empty($album->images) && $album->images->count() > 0)
                                <form id="delete_selected_images_form">
                                    <div class="d-flex flex-wrap mb-2 align-items-center">
                                        <button type="button" id="select_all_images" class="btn btn-secondary mr-2"
                                            style="margin: 5px;">{{ __('dashboard.select_all') }}</button>
                                        <button type="button" id="unselect_all_images"
                                            class="btn btn-secondary mr-2"
                                            style="margin: 5px;">{{ __('dashboard.unselect_all') }}</button>
                                        <button type="button" id="delete_selected_images"
                                            class="btn btn-danger mr-2"
                                            style="margin: 5px;">{{ __('dashboard.delete_selected') }}</button>
                                        <button type="button" id="delete_all_images" class="btn btn-danger mr-2"
                                            style="margin: 5px;">{{ __('dashboard.delete_all') }}</button>
                                        <button type="button" id="save_order_btn" class="btn btn-success mr-2"
                                            style="margin: 5px;">{{ __('dashboard.save_order') }}</button>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="row mb-0" id="sortable-images">
                                            @foreach ($album->images as $key => $image)
                                                <div class="col-xs-6 col-sm-2 col-md-2 col-xl-2 mb-2 pl-sm-2 pr-sm-2 sortable-container"
                                                    data-id="{{ $image->id }}"
                                                    data-responsive="{{ $image->image_url }}"
                                                    data-src="{{ $image->image_url }}"
                                                    data-sub-html="<h4> {{ __('dashboard.image') }} {{ $key + 1 }}</h4>">
                                                    <div
                                                        class="d-flex flex-column align-items-center position-relative">
                                                        <div class="drag-handle">⋮⋮</div>
                                                        <input type="checkbox" name="selected_images[]"
                                                            value="{{ $image->id }}"
                                                            class="select_image_checkbox mb-2">
                                                        <a href="javascript:;">
                                                            <img class="img-responsive" src="{{ $image->image_url }}"
                                                                width="150px" height="150px">
                                                        </a>
                                                        <div>
                                                            <br>
                                                            <a href='#' data-image='{{ $image->id }}'
                                                                class='delete_img_btn btn btn-danger'>{{ __('dashboard.delete') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" @checked(old('status', $album->status)) />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="show_in_home" @checked(old('show_in_home', $album->show_in_home)) />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1"
                                            name="show_in_header" @checked(old('show_in_header', $album->show_in_header)) />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }} </h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1"
                                            name="show_in_footer" @checked(old('show_in_footer', $album->show_in_footer)) />
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
                                    <div class="form-group col-md-2">
                                        <label for="name_ar">{{ __('dashboard.slug_en') }}</label>
                                        <input type="text" autocomplete="off" class="form-control"
                                            placeholder="{{ __('dashboard.slug_en') }}" name="slug_en"
                                            value="{{ $album->slug_en }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{ __('dashboard.meta_title_en') }}</label>
                                        <textarea class="form-control" name="meta_title_en" placeholder="{{ __('dashboard.meta_title_en') }}"> {!! $album->meta_title_en !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="meta_desc"> {{ __('dashboard.meta_desc_en') }}</label>
                                        <textarea class="form-control" name="meta_desc_en" placeholder="{{ __('dashboard.meta_desc_en') }}"> {!! $album->meta_desc_en !!}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <hr>

                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>{{ __('dashboard.slug_ar') }}</label>
                                        <input type="text" autocomplete="off" class="form-control"
                                            placeholder="{{ __('dashboard.slug_ar') }}" name="slug_ar"
                                            value="{{ $album->slug_ar }}">
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{ __('dashboard.meta_title_ar') }}</label>
                                        <textarea class="form-control" name="meta_title_ar" placeholder="{!! __('dashboard.meta_title_ar') !!}">{{ $album->meta_title_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label> {{ __('dashboard.meta_desc_ar') }}</label>
                                        <textarea class="form-control" name="meta_desc_ar" placeholder="{!! __('dashboard.meta_desc') !!}">{!! $album->meta_desc_ar !!}</textarea>
                                    </div>


                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)</h5>
                                        <input type="checkbox" id="switch5" switch="none" value="1"
                                            name="index" @checked(old('index', $album->index)) />
                                        <label for="switch5" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.update') }} </button>
                                <a href="{{ route('dashboard.albums.index') }}"><button type="button"
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

    <!-- modal1 -->
    <div class="modal fade text-left" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h3 class="modal-title" id="myModalLabel34">{{ trans('home.edit_category') }}</h3>
                    <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                        X
                    </a>
                </div>
                <form action="{{ route('dashboard.albums.changeAlbum', $album->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <select class="form-control" data-trigger name="category_id" id="category" required>
                                    <option></option>
                                    @foreach ($albums as $album)
                                        <option value="{{ $album->id }}"
                                            {{ $album->album_id == $album->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? $album->name_en : $album->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary w-md"> {{ trans('home.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- SortableJS for drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Album Image Management Script Loading...');

            // تهيئة Sortable للصور
            var sortableEl = document.getElementById('sortable-images');
            if (sortableEl) {
                Sortable.create(sortableEl, {
                    animation: 150,
                    handle: '.drag-handle',
                    ghostClass: 'sortable-ghost'
                });
                console.log('✅ Sortable initialized');
            }

            // زر تحديد الكل
            var selectAllBtn = document.getElementById('select_all_images');
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Select All clicked');
                    document.querySelectorAll('.select_image_checkbox').forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                });
            }

            // زر إلغاء تحديد الكل
            var unselectAllBtn = document.getElementById('unselect_all_images');
            if (unselectAllBtn) {
                unselectAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Unselect All clicked');
                    document.querySelectorAll('.select_image_checkbox').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                });
            }

            // زر حذف المحدد
            var deleteSelectedBtn = document.getElementById('delete_selected_images');
            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Delete Selected clicked');

                    var selectedIds = [];
                    document.querySelectorAll('.select_image_checkbox:checked').forEach(function(checkbox) {
                        var container = checkbox.closest('.sortable-container');
                        if (container) {
                            selectedIds.push(container.getAttribute('data-id'));
                        }
                    });

                    console.log('Selected IDs:', selectedIds);

                    if (selectedIds.length === 0) {
                        alert('{{ __('dashboard.please_select_images_to_delete') }}');
                        return;
                    }

                    if (!confirm('{{ __('dashboard.confirm_delete_selected_images') }}')) {
                        return;
                    }

                    fetch('{{ route('dashboard.albums.deleteSelectedImages') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                image_ids: selectedIds,
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Delete response:', data);
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete'));
                            }
                        })
                        .catch(error => {
                            console.error('Delete error:', error);
                            alert('Error: Failed to delete');
                        });
                });
            }

            // زر حذف الكل
            var deleteAllBtn = document.getElementById('delete_all_images');
            if (deleteAllBtn) {
                deleteAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Delete All clicked');

                    if (!confirm('{{ __('dashboard.confirm_delete_all_images') }}')) {
                        return;
                    }

                    fetch('{{ route('dashboard.albums.deleteAllImages') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                album_id: '{{ $album->id ?? '' }}',
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Delete all response:', data);
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete'));
                            }
                        })
                        .catch(error => {
                            console.error('Delete all error:', error);
                            alert('Error: Failed to delete all');
                        });
                });
            }

            // زر حفظ الترتيب
            var saveOrderBtn = document.getElementById('save_order_btn');
            if (saveOrderBtn) {
                saveOrderBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Save Order clicked');

                    var imageIds = [];
                    document.querySelectorAll('#sortable-images .sortable-container').forEach(function(
                        container) {
                        imageIds.push(container.getAttribute('data-id'));
                    });

                    console.log('Image order:', imageIds);

                    if (imageIds.length === 0) {
                        alert('{{ __('dashboard.no_images_to_save_order') }}');
                        return;
                    }

                    fetch('{{ route('dashboard.albums.reorderImages') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                image_ids: imageIds,
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Save order response:', data);
                            if (data.success) {
                                alert('{{ __('dashboard.order_saved_successfully') }}');
                            } else {
                                alert('Error: ' + (data.message || 'Failed to save'));
                            }
                        })
                        .catch(error => {
                            console.error('Save order error:', error);
                            alert('Error: Failed to save');
                        });
                });
            }

            // أزرار الحذف الفردية تحت كل صورة
            document.querySelectorAll('.delete_img_btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var imageId = this.getAttribute('data-image');
                    console.log('Delete single image clicked:', imageId);

                    if (!confirm('{{ __('dashboard.confirm_delete_this_image') }}')) {
                        return;
                    }

                    fetch('{{ route('dashboard.albums.deleteImage') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                image: imageId,
                                albumId: '{{ $album->id ?? '' }}',
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Delete image response:', data);
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete image'));
                            }
                        })
                        .catch(error => {
                            console.error('Delete image error:', error);
                            alert('Error: Failed to delete image');
                        });
                });
            });

            console.log('✅ All buttons initialized');
        });
    </script>

</x-dashboard.layout>

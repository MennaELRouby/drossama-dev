<x-dashboard.layout :title="__('dashboard.edit') . ' ' . $service->name">

    @push('styles')
        <style>
            img {
                display: block !important;
            }

            .dz-hidden-input {
                position: absolute !important;
                top: 0px !important;
                left: 250px !important;
            }

            .sortable-container {
                cursor: move;
            }

            .sortable-container.sortable-ghost {
                opacity: 0.5;
            }

            /* تحسين مظهر الـ drag handle */
            .drag-handle {
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                padding: 5px 8px;
                border-radius: 4px;
                cursor: move;
                font-size: 14px;
                z-index: 10;
                user-select: none;
                transition: all 0.3s ease;
            }

            .drag-handle:hover {
                background: rgba(0, 0, 0, 0.9);
                transform: scale(1.1);
            }

            .sortable-container:hover .drag-handle {
                opacity: 1;
            }

            .drag-handle:active {
                transform: scale(0.95);
            }

            /* تحسين مظهر التعليمات */
            .alert-info {
                border-left: 4px solid #17a2b8;
                background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            }

            .sortable-container.sortable-chosen {
                background-color: #f8f9fa;
                border: 2px dashed #007bff;
            }

            .drag-handle {
                cursor: move;
                position: absolute;
                top: 5px;
                right: 5px;
                background: rgba(0, 0, 0, 0.5);
                color: white;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 12px;
                z-index: 10;
            }

            .ai-loading {
                opacity: 0.6;
                pointer-events: none;
            }
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    @endpush

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . ' ' . $service->name" :label_url="route('dashboard.services.index')" :label="__('dashboard.services')" />
    <!-- End Page Header -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.edit') . ' ' . $service->name }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.services.update', [$service->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <x-dashboard.multilingual-input name="name" type="text" :required="true"
                                :model="$service" />

                            <div class="form-group col-md-2">
                                <label>{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number"
                                    value="{{ old('order', $service->order) }}"
                                    placeholder="{{ __('dashboard.order') }}">
                                @error('order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="parent">{{ __('dashboard.parent') }}</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">{{ __('dashboard.no_parent') }}</option>
                                    @foreach ($services as $serviceItem)
                                        <option value="{{ $serviceItem->id }}"
                                            {{ old('parent_id', $service->parent_id) == $serviceItem->id ? 'selected' : '' }}>
                                            {{ $serviceItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="">{{ __('dashboard.current_image') }}</label>
                                @if ($service->image_path)
                                    <img src="{{ $service->image_path }}" width="150" class="img-thumbnail">
                                @else
                                    <p class="text-muted">{{ __('dashboard.no_image') }}</p>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    placeholder="{{ __('dashboard.alt_image') }}"
                                    value="{{ old('alt_image', $service->alt_image) }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon" accept="image/*">
                                @error('icon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="">{{ __('dashboard.current_icon') }}</label>
                                @if ($service->icon_path)
                                    <img src="{{ $service->icon_path }}" width="150" class="img-thumbnail">
                                @else
                                    <p class="text-muted">{{ __('dashboard.no_icon') }}</p>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    placeholder="{{ __('dashboard.alt_icon') }}"
                                    value="{{ old('alt_icon', $service->alt_icon) }}">
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <!-- Multilingual Short Description -->
                            <x-dashboard.multilingual-input name="short_desc" type="textarea" :required="true"
                                rows="4" :model="$service" />
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="10"
                                :model="$service" />

                            <!-- AI Content Generation Section -->
                            <div class="col-12">
                                <hr>
                                <h4 class="card-title">
                                    <i class="fas fa-robot"></i> {{ __('dashboard.ai_content_generation_with_ai') }}
                                </h4>
                                <p class="text-muted">{{ __('dashboard.ai_content_description') }}</p>

                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="form-label">{{ __('dashboard.content_type_for_long_description') }}</label>
                                                <select class="form-control" id="aiContentType">
                                                    <option value="">{{ __('dashboard.choose_content_type') }}
                                                    </option>
                                                    <option value="detailed_description">
                                                        {{ __('dashboard.detailed_service_description') }}</option>
                                                    <option value="benefits_features">
                                                        {{ __('dashboard.service_benefits_features') }}</option>
                                                    <option value="technical_details">
                                                        {{ __('dashboard.technical_details') }}</option>
                                                    <option value="seo_content">
                                                        {{ __('dashboard.seo_optimized_content') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="form-label">{{ __('dashboard.required_language') }}</label>
                                                <select class="form-control" id="aiLanguage">
                                                    <option value="ar">{{ __('dashboard.arabic') }}</option>
                                                    <option value="en">English</option>
                                                    <option value="both">{{ __('dashboard.both_languages') }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label
                                                    class="form-label">{{ __('dashboard.service_description_or_keywords') }}</label>
                                                <textarea class="form-control" id="aiPrompt" rows="3"
                                                    placeholder="{{ __('dashboard.service_description_placeholder') }}">{{ $service->name }}</textarea>
                                                <small
                                                    class="form-text text-muted">{{ __('dashboard.service_description_help_text') }}</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('dashboard.content_length') }}</label>
                                                <select class="form-control" id="aiLength">
                                                    <option value="short">{{ __('dashboard.short_content') }}
                                                    </option>
                                                    <option value="medium" selected>
                                                        {{ __('dashboard.medium_content') }}</option>
                                                    <option value="long">{{ __('dashboard.long_content') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-primary w-100"
                                                    id="generateServiceContent">
                                                    <i
                                                        class="fas fa-magic me-2"></i>{{ __('dashboard.generate_content') }}
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="aiGenerationStatus" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- AI Image Generation Section -->
                            <div class="col-12">
                                <hr>
                                <h4 class="card-title">
                                    <i class="fas fa-image"></i> {{ __('dashboard.ai_image_generation') }}
                                </h4>
                                <p class="text-muted">{{ __('dashboard.ai_image_description') }}</p>

                                <div class="card border-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label
                                                    class="form-label">{{ __('dashboard.image_description') }}</label>
                                                <textarea class="form-control" id="aiImagePrompt" rows="3"
                                                    placeholder="{{ __('dashboard.image_description_placeholder') }}">{{ $service->name }}</textarea>
                                                <small
                                                    class="form-text text-muted">{{ __('dashboard.image_description_help_text') }}</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('dashboard.image_style') }}</label>
                                                <select class="form-control" id="aiImageStyle">
                                                    <option value="">{{ __('dashboard.choose_image_style') }}
                                                    </option>
                                                    <option value="realistic">{{ __('dashboard.realistic') }}</option>
                                                    <option value="digital-art">{{ __('dashboard.digital_art') }}
                                                    </option>
                                                    <option value="illustration">{{ __('dashboard.illustration') }}
                                                    </option>
                                                    <option value="cartoon">{{ __('dashboard.cartoon') }}</option>
                                                    <option value="photography">{{ __('dashboard.photography') }}
                                                    </option>
                                                    <option value="abstract">{{ __('dashboard.abstract') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('dashboard.image_size') }}</label>
                                                <select class="form-control" id="aiImageSize">
                                                    <option value="512x512">{{ __('dashboard.small_512x512') }}
                                                    </option>
                                                    <option value="1024x1024" selected>
                                                        {{ __('dashboard.medium_1024x1024') }}</option>
                                                    <option value="1024x1792">{{ __('dashboard.large_1024x1792') }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-success w-100"
                                                    id="generateServiceImage">
                                                    <i
                                                        class="fas fa-magic me-2"></i>{{ __('dashboard.generate_image') }}
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="aiImageGenerationStatus" class="mt-2"></div>
                                            </div>

                                            <!-- Generated Images Display -->
                                            <div class="col-md-12 mt-3">
                                                <h5>{{ __('dashboard.generated_images') }}</h5>
                                                <div id="generatedImages" class="row">
                                                    <div class="col-12 text-center text-muted">
                                                        <p>{{ __('dashboard.no_images_generated') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="service_images">{{ trans('dashboard.service_images') }}</label>
                                <input type="file" class="form-control" name="service_images[]" multiple
                                    accept="image/*">
                                <small class="form-text text-muted">{{ __('dashboard.max_file_size_1mb') }}</small>
                                @error('service_images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (!empty($service->images) && $service->images->count() > 0)
                                <div class="col-12">
                                    <hr>
                                    <h5>{{ __('dashboard.current_images') }}</h5>

                                    <div class="d-flex flex-wrap mb-3 align-items-center">
                                        <button type="button" id="select_all_images"
                                            class="btn btn-secondary me-2 mb-2">
                                            {{ trans('dashboard.select_all') }}
                                        </button>
                                        <button type="button" id="unselect_all_images"
                                            class="btn btn-secondary me-2 mb-2">
                                            {{ trans('dashboard.unselect_all') }}
                                        </button>
                                        <button type="button" id="delete_selected_images"
                                            class="btn btn-danger me-2 mb-2">
                                            {{ trans('dashboard.delete_selected') }}
                                        </button>
                                        <button type="button" id="delete_all_images"
                                            class="btn btn-danger me-2 mb-2">
                                            {{ trans('dashboard.delete_all') }}
                                        </button>
                                        <button type="button" id="save_order_btn" class="btn btn-success me-2 mb-2">
                                            {{ trans('dashboard.save_order') }}
                                        </button>
                                    </div>

                                    <!-- تعليمات للمستخدم -->
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>{{ __('dashboard.drag_drop_instructions') }}:</strong>
                                        {{ __('dashboard.drag_drop_description') }}
                                    </div>

                                    <div class="row" id="sortable-images">
                                        @foreach ($service->images as $key => $image)
                                            <div class="col-md-3 col-sm-6 mb-3 sortable-container"
                                                data-id="{{ $image->id }}">
                                                <div class="card">
                                                    <div class="position-relative">
                                                        <div class="drag-handle">⋮⋮</div>
                                                        <img class="card-img-top" src="{{ $image->image_url }}"
                                                            style="height: 200px; object-fit: cover;">
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <input type="checkbox" name="selected_images[]"
                                                            value="{{ $image->id }}"
                                                            class="select_image_checkbox mb-2">
                                                        <button type="button" data-image="{{ $image->id }}"
                                                            class="delete_img_btn btn btn-danger btn-sm">
                                                            {{ trans('dashboard.delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }}</h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" {{ old('status', $service->status) ? 'checked' : '' }} />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="show_in_home"
                                            {{ old('show_in_home', $service->show_in_home) ? 'checked' : '' }} />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }}</h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1"
                                            name="show_in_header"
                                            {{ old('show_in_header', $service->show_in_header) ? 'checked' : '' }} />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }}</h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1"
                                            name="show_in_footer"
                                            {{ old('show_in_footer', $service->show_in_footer) ? 'checked' : '' }} />
                                        <label for="switch4" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h4 class="card-title">{{ __('dashboard.seo') }}</h4>

                                <div class="row">
                                    <x-dashboard.multilingual-input name="slug" type="text" :required="false"
                                        :model="$service" />
                                    <x-dashboard.multilingual-input name="meta_title" type="textarea"
                                        :required="false" :rows="2" :model="$service" />
                                    <x-dashboard.multilingual-input name="meta_desc" type="textarea"
                                        :required="false" :rows="2" :model="$service" />

                                    <div class="form-group col-md-12">
                                        <div class="d-flex flex-wrap gap-2">
                                            <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)
                                            </h5>
                                            <input type="checkbox" id="switch5" switch="none" value="1"
                                                name="index"
                                                {{ old('index', $service->index) ? 'checked' : '' }} />
                                            <label for="switch5" data-on-label="{{ __('dashboard.yes') }}"
                                                data-off-label="{{ __('dashboard.no') }}"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="icon-note"></i> {{ __('dashboard.update') }}
                                </button>
                                <a href="{{ route('dashboard.services.index') }}" class="btn btn-danger ms-2">
                                    <i class="icon-trash"></i> {{ __('dashboard.cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- SortableJS for drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Image Management Script Loading...');

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

                    fetch('{{ route('dashboard.services.deleteSelectedImages') }}', {
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

                    fetch('{{ route('dashboard.services.deleteAllImages') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                service_id: '{{ $service->id ?? '' }}',
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

                    fetch('{{ route('dashboard.services.reorderImages') }}', {
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

                    fetch('{{ route('dashboard.services.deleteImage') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                image: imageId,
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

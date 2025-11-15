<x-dashboard.layout :title="__('dashboard.add_blog')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_blog')" :label_url="route('dashboard.blogs.index')" :label="__('dashboard.blogs')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_blog') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true" />

                            <div class="form-group col-md-3">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ old('order', 0) }}"
                                    placeholder="{{ __('dashboard.order') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="category">{{ __('dashboard.category') }}</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="" {{ !old('category_id') ? 'selected' : '' }}>
                                        {{ __('dashboard.no_category') }}</option>

                                    @foreach ($categories as $blog_category)
                                        <option @selected(old('category_id') == $blog_category->id) value="{{ $blog_category->id }}">
                                            {{ $blog_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="category">{{ __('dashboard.author') }}</label>
                                <select class="form-control " name="author_id">
                                    <option value="" {{ !old('author_id') ? 'selected' : '' }}>
                                        {{ __('dashboard.no_author') }}</option>

                                    @foreach ($authors as $author)
                                        <option @selected(old('author_id') == $author->id) value="{{ $author->id }}">
                                            {{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="date" class="form-label">{{ __('dashboard.date') }}</label>
                                <input class="form-control" type="date" name="date" value="{{ old('date') }}"
                                    placeholder="{{ __('dashboard.date') }}">
                            </div>



                            <div class=" form-group  col-md-8">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-8">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon">

                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    value="{{ old('alt_icon') }}" placeholder="{{ __('dashboard.alt_icon') }}">
                            </div>


                            <!-- Multilingual Short Description -->

                            <x-dashboard.multilingual-input name="short_desc" type="textarea" rows="4" />

                            <!-- للـ Rich Text Editor (TinyMCE) -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="10" />

                            <!-- للـ Meta Tags -->

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
                                                    <option value="detailed_article">
                                                        {{ __('dashboard.detailed_article_content') }}</option>
                                                    <option value="news_article">
                                                        {{ __('dashboard.news_article_format') }}</option>
                                                    <option value="tutorial_guide">
                                                        {{ __('dashboard.tutorial_guide') }}</option>
                                                    <option value="seo_article">
                                                        {{ __('dashboard.seo_optimized_article') }}</option>
                                                    <option value="blog_post">{{ __('dashboard.blog_post_format') }}
                                                    </option>
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
                                                    class="form-label">{{ __('dashboard.article_topic_or_keywords') }}</label>
                                                <textarea class="form-control" id="aiPrompt" rows="3"
                                                    placeholder="{{ __('dashboard.article_topic_placeholder') }}"></textarea>
                                                <small
                                                    class="form-text text-muted">{{ __('dashboard.article_topic_help_text') }}</small>
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
                                                    id="generateBlogContent">
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

                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                        <input type="checkbox" id="switch1" switch="none" value="1"
                                            name="status" checked />
                                        <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="show_in_home" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }} </h5>
                                        <input type="checkbox" id="switch3" switch="none" value="1"
                                            name="show_in_header" checked />
                                        <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }} </h5>
                                        <input type="checkbox" id="switch4" switch="none" value="1"
                                            name="show_in_footer" checked />
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

                                    <!-- Multilingual Meta Title -->
                                    <x-dashboard.multilingual-input name="meta_title" type="textarea" rows="2" />

                                    <div class="form-group col-md-12">
                                        <hr>
                                    </div>

                                    <!-- Multilingual Meta Description -->
                                    <x-dashboard.multilingual-input name="meta_desc" type="textarea" rows="3" />


                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)</h5>
                                        <input type="checkbox" id="switch2" switch="none" value="1"
                                            name="index" checked />
                                        <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.save') }} </button>
                                <a href="{{ route('dashboard.blogs.index') }}"><button type="button"
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
        <!-- TinyMCE Self-hosted -->
        <script src="{{ asset('assets/dashboard/tinymce/tinymce.min.js') }}"></script>
        <script>
            // Initialize TinyMCE with proper settings to avoid API warnings
            document.addEventListener('DOMContentLoaded', function() {
                const textareas = document.querySelectorAll(
                    'textarea[id$="_editor"], textarea[name*="long_desc"], textarea[name*="short_desc"]');

                textareas.forEach(function(textarea, index) {
                    let uniqueId = textarea.id;
                    if (!textarea.id) {
                        uniqueId = 'tinymce_editor_' + index + '_' + textarea.name.replace(/[^a-zA-Z0-9]/g,
                            '_');
                        textarea.id = uniqueId;
                    }

                    tinymce.init({
                        selector: '#' + uniqueId,
                        height: 400,
                        menubar: false,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'help', 'wordcount',
                            'directionality'
                        ],
                        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code help',
                        content_style: 'body { font-family: Helvetica, Arial, sans-serif; font-size: 14px }',
                        branding: false,
                        promotion: false,
                        license_key: 'gpl',
                        setup: function(editor) {
                            editor.on('change', function() {
                                editor.save();
                            });
                        }
                    });
                });
            });
        </script>

        <!-- Blog AI Content Generation -->
        <script src="{{ asset('js/blog-ai-content.js') }}" defer></script>
    @endsection

</x-dashboard.layout>

<x-dashboard.layout :title="__('dashboard.add_service')">

    @section('style')
        <style>
            .ai-loading {
                opacity: 0.6;
                pointer-events: none;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .alert {
                margin-top: 0.5rem;
            }
        </style>
    @endsection

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_service')" :label_url="route('dashboard.services.index')" :label="__('dashboard.services')" />
    <!-- End Page Header -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_service') }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Multilingual Name Fields -->
                            <x-dashboard.multilingual-input name="name" type="text" :required="true" />

                            <div class="form-group col-md-1">
                                <label>{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ old('order', 0) }}"
                                    placeholder="{{ __('dashboard.order') }}">
                                @error('order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-1">
                                <label for="parent">{{ __('dashboard.parent') }}</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="" {{ !old('parent_id') ? 'selected' : '' }}>
                                        {{ __('dashboard.no_parent') }}
                                    </option>
                                    @foreach ($services as $serviceItem)
                                        <option value="{{ $serviceItem->id }}"
                                            {{ old('parent_id') == $serviceItem->id ? 'selected' : '' }}>
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

                            <div class="form-group col-md-8">
                                <label>{{ __('dashboard.image') }} (225px * 225px max 1mb)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_image') }}</label>
                                <input class="form-control" name="alt_image" type="text"
                                    value="{{ old('alt_image') }}" placeholder="{{ __('dashboard.alt_image') }}">
                            </div>

                            <div class="form-group col-md-8">
                                <label>{{ __('dashboard.icon') }} (50px * 50px max 1mb)</label>
                                <input type="file" class="form-control" name="icon" accept="image/*">
                                @error('icon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.alt_icon') }}</label>
                                <input class="form-control" name="alt_icon" type="text"
                                    value="{{ old('alt_icon') }}" placeholder="{{ __('dashboard.alt_icon') }}">
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>
                            <!-- Multilingual Short Description -->
                            <x-dashboard.multilingual-input name="short_desc" type="textarea" :required="true"
                                rows="4" />
                            <!-- Multilingual Long Description -->
                            <x-dashboard.multilingual-input name="long_desc" type="editor" rows="8" />

                            <h4 class="card-title">
                                <i class="fas fa-robot"></i> توليد المحتوى بواسطة AI
                            </h4>
                            <p class="text-muted">يمكنك استخدام الذكاء الاصطناعي لتوليد محتوى للخدمة</p>

                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">نوع المحتوى للوصف الطويل</label>
                                            <select class="form-control" id="aiContentType">
                                                <option value="">اختر نوع المحتوى</option>
                                                <option value="detailed_description">وصف تفصيلي للخدمة</option>
                                                <option value="benefits_features">فوائد ومميزات الخدمة</option>
                                                <option value="technical_details">التفاصيل التقنية</option>
                                                <option value="seo_content">محتوى محسن لمحركات البحث</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">اللغة المطلوبة</label>
                                            <select class="form-control" id="aiLanguage">
                                                <option value="ar">العربية</option>
                                                <option value="en">English</option>
                                                <option value="both">كلا اللغتين</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">وصف الخدمة أو الكلمات المفتاحية</label>
                                            <textarea class="form-control" id="aiPrompt" rows="3"
                                                placeholder="مثال: خدمة تصميم المواقع الإلكترونية، تطوير تطبيقات الجوال، استضافة المواقع..."></textarea>
                                            <small class="form-text text-muted">اكتب وصف مختصر عن الخدمة أو الكلمات
                                                المفتاحية المطلوبة</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">طول المحتوى</label>
                                            <select class="form-control" id="aiLength">
                                                <option value="short">قصير (200-400 كلمة)</option>
                                                <option value="medium" selected>متوسط (500-800 كلمة)</option>
                                                <option value="long">طويل (1000-1500 كلمة)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100"
                                                id="generateServiceContent">
                                                <i class="fas fa-magic me-2"></i>توليد المحتوى
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <div id="aiGenerationStatus" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }}</h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1"
                                        name="status" {{ old('status', true) ? 'checked' : '' }} />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_home') }}</h5>
                                    <input type="checkbox" id="switch2" switch="none" value="1"
                                        name="show_in_home" {{ old('show_in_home', true) ? 'checked' : '' }} />
                                    <label for="switch2" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_header') }}</h5>
                                    <input type="checkbox" id="switch3" switch="none" value="1"
                                        name="show_in_header" {{ old('show_in_header', true) ? 'checked' : '' }} />
                                    <label for="switch3" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.show_in_footer') }}</h5>
                                    <input type="checkbox" id="switch4" switch="none" value="1"
                                        name="show_in_footer" {{ old('show_in_footer', true) ? 'checked' : '' }} />
                                    <label for="switch4" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                            <h4 class="card-title">{{ __('dashboard.seo') }}</h4>

                            <div class="row">
                                <!-- Multilingual Meta Title -->
                                    <x-dashboard.multilingual-input name="meta_title" type="textarea" rows="2" />

                                    <div class="form-group col-md-12">
                                        <hr>
                                    </div>

                                    <!-- Multilingual Meta Description -->
                                    <x-dashboard.multilingual-input name="meta_desc" type="textarea" rows="3" />

                                <div class="form-group col-md-12">
                                    <div class="d-flex flex-wrap gap-2">
                                        <h5 class="font-size-14 mb-3">{{ __('dashboard.meta_robots') }} (index)</h5>
                                        <input type="checkbox" id="switch5" switch="none" value="1"
                                            name="index" {{ old('index', true) ? 'checked' : '' }} />
                                        <label for="switch5" data-on-label="{{ __('dashboard.yes') }}"
                                            data-off-label="{{ __('dashboard.no') }}"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success">
                                <i class="icon-note"></i> {{ __('dashboard.save') }}
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

        <script type="text/javascript">
            var token = "{{ csrf_token() }}";

            $(document).ready(function() {

                // Setup CSRF token for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // File size validation
                $('input[type="file"]').on('change', function(e) {
                    var maxSize = 1 * 1024 * 1024; // 1MB
                    var files = this.files;

                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            alert('أقصى حجم للصورة هو 1 ميجا');
                            this.value = ""; // Clear the field
                            break;
                        }
                    }
                });

                // AI Content Generation
                $('#generateServiceContent').on('click', function(e) {
                    e.preventDefault();

                    // Get form values
                    var contentType = $('#aiContentType').val();
                    var prompt = $('#aiPrompt').val().trim();
                    var language = $('#aiLanguage').val();
                    var length = $('#aiLength').val();

                    // Auto-fill prompt from service names if empty
                    if (!prompt) {
                        var nameEn = $('input[name="name_en"]').val();
                        var nameAr = $('input[name="name_ar"]').val();
                        if (nameAr) {
                            prompt = nameAr;
                            $('#aiPrompt').val(prompt);
                        } else if (nameEn) {
                            prompt = nameEn;
                            $('#aiPrompt').val(prompt);
                        }
                    }

                    // Validation
                    if (!contentType) {
                        alert('يرجى اختيار نوع المحتوى');
                        return;
                    }

                    if (!prompt) {
                        alert('يرجى إدخال وصف الخدمة أو اسم الخدمة أولاً');
                        return;
                    }

                    // Show loading state
                    var $btn = $(this);
                    var originalText = $btn.html();
                    $btn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin me-2"></i>جاري التوليد...');

                    // Add loading class to the form
                    $('.card').addClass('ai-loading');

                    // Create the prompt based on content type and language
                    var fullPrompt = createAIPrompt(contentType, prompt, language, length);

                    // Show status
                    showStatus('جاري توليد المحتوى...', 'info');

                    // AJAX request to generate content
                    $.ajax({
                        url: '{{ route('dashboard.ai-content.generate') }}',
                        method: 'POST',
                        data: {
                            type: 'service_content',
                            prompt: fullPrompt,
                            content_type: contentType,
                            language: language,
                            length: length,
                            options: {
                                max_tokens: getTokensByLength(length),
                                temperature: 0.7
                            },
                            _token: token
                        },
                        success: function(response) {
                            console.log('AI Response:', response);

                            if (response.success && response.content) {
                                var content = response.content.content || response.content;

                                // Apply content based on language selection
                                applyGeneratedContent(content, language, contentType);

                                showStatus('تم توليد المحتوى بنجاح!', 'success');

                            } else {
                                var errorMsg = response.error || response.message ||
                                    'فشل في توليد المحتوى';
                                showStatus(errorMsg, 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AI Generation Error:', {
                                xhr,
                                status,
                                error
                            });

                            var errorMsg = 'حدث خطأ في توليد المحتوى';

                            if (xhr.status === 419) {
                                errorMsg = 'انتهت صلاحية الصفحة، يرجى إعادة تحميل الصفحة';
                            } else if (xhr.status === 500) {
                                errorMsg = 'خطأ في الخادم';
                            } else if (xhr.status === 404) {
                                errorMsg = 'الخدمة غير متوفرة حالياً';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            showStatus(errorMsg, 'danger');
                        },
                        complete: function() {
                            // Restore button state
                            $btn.prop('disabled', false).html(originalText);
                            $('.card').removeClass('ai-loading');
                        }
                    });
                });

                // Helper function to create AI prompt
                function createAIPrompt(contentType, prompt, language, length) {
                    var basePrompt = '';
                    var languageInstruction = '';
                    var formattingInstruction =
                        'نسق النص باستخدام HTML tags مناسبة مثل <h2>, <h3>, <p>, <ul>, <li>, <strong>, <em> لجعل المحتوى منظم وسهل القراءة.';

                    // Set language instruction
                    if (language === 'ar') {
                        languageInstruction = 'اكتب النص باللغة العربية فقط.';
                    } else if (language === 'en') {
                        languageInstruction =
                            'Write the text in English only. Format the text using appropriate HTML tags like <h2>, <h3>, <p>, <ul>, <li>, <strong>, <em> to make the content organized and easy to read.';
                        formattingInstruction = ''; // Already included in English instruction
                    } else if (language === 'de') {
                        languageInstruction = 'Write the text in German only.';
                    } else {
                        languageInstruction = 'اكتب النص باللغة العربية أولاً، ثم بالإنجليزية.';
                    }

                    // Create prompt based on content type
                    switch (contentType) {
                        case 'detailed_description':
                            basePrompt =
                                `اكتب وصف تفصيلي ومفصل لخدمة: ${prompt}. يجب أن يكون الوصف جذاب ومفيد للعملاء المحتملين، يشرح طبيعة الخدمة وفوائدها. استخدم عناوين فرعية وقوائم منظمة.`;
                            break;
                        case 'benefits_features':
                            basePrompt =
                                `اكتب عن فوائد ومميزات خدمة: ${prompt}. ركز على القيمة المضافة والمزايا التنافسية التي تقدمها هذه الخدمة للعملاء. استخدم قوائم نقطية لعرض الفوائد بوضوح.`;
                            break;
                        case 'technical_details':
                            basePrompt =
                                `اكتب التفاصيل التقنية والمواصفات لخدمة: ${prompt}. يجب أن يكون النص دقيق ومفصل تقنياً ومفهوم للمختصين. استخدم عناوين فرعية وقوائم للمواصفات.`;
                            break;
                        case 'seo_content':
                            basePrompt =
                                `اكتب محتوى محسن لمحركات البحث عن خدمة: ${prompt}. استخدم الكلمات المفتاحية بشكل طبيعي ومفيد للعملاء. استخدم عناوين H2 و H3 وقوائم منظمة لتحسين SEO.`;
                            break;
                        default:
                            basePrompt = `اكتب وصف شامل عن خدمة: ${prompt}. استخدم تنسيق HTML مناسب.`;
                    }

                    return `${basePrompt} ${languageInstruction} ${formattingInstruction}`;
                }

                // Helper function to get tokens by length
                function getTokensByLength(length) {
                    switch (length) {
                        case 'short':
                            return 300; // زيادة من 150 إلى 300
                        case 'medium':
                            return 800; // زيادة من 400 إلى 800
                        case 'long':
                            return 1500; // زيادة من 600 إلى 1500
                        default:
                            return 800;
                    }
                }

                // Helper function to apply generated content
                function applyGeneratedContent(content, language, contentType) {
                    console.log('Applying generated content:', {
                        content,
                        language,
                        contentType
                    });

                    if (language === 'both') {
                        // Try to split content for both languages
                        var splitContent = splitBilingualContent(content);
                        if (splitContent.ar && splitContent.en) {
                            applyToFields(formatContentForEditor(splitContent.ar), 'ar', contentType);
                            applyToFields(formatContentForEditor(splitContent.en), 'en', contentType);
                        } else {
                            // If splitting fails, apply to Arabic fields
                            applyToFields(formatContentForEditor(content), 'ar', contentType);
                        }
                    } else {
                        applyToFields(formatContentForEditor(content), language, contentType);
                    }
                }

                // Helper function to format content for better display in TinyMCE
                function formatContentForEditor(content) {
                    if (!content) return content;

                    // If content doesn't have HTML tags, add basic formatting
                    if (!content.includes('<') && !content.includes('>')) {
                        // Split by double line breaks for paragraphs
                        let paragraphs = content.split(/\n\n+/);
                        let formattedContent = '';

                        for (let para of paragraphs) {
                            if (para.trim()) {
                                // Check if it looks like a heading (short line, often ends with :)
                                if (para.length < 100 && (para.includes(':') || para.match(/^[\u0600-\u06FF\s]+$/))) {
                                    formattedContent += `<h3>${para.trim()}</h3>\n`;
                                }
                                // Check if it looks like a list item (starts with • or -)
                                else if (para.includes('•') || para.includes('-')) {
                                    let listItems = para.split(/[•-]/);
                                    if (listItems.length > 1) {
                                        formattedContent += '<ul>\n';
                                        for (let item of listItems) {
                                            if (item.trim()) {
                                                formattedContent += `<li>${item.trim()}</li>\n`;
                                            }
                                        }
                                        formattedContent += '</ul>\n';
                                    } else {
                                        formattedContent += `<p>${para.trim()}</p>\n`;
                                    }
                                } else {
                                    formattedContent += `<p>${para.trim()}</p>\n`;
                                }
                            }
                        }

                        return formattedContent;
                    } else {
                        // Content already has HTML tags, just clean it up
                        return content.replace(/\n\n+/g, '\n').trim();
                    }
                }

                // Helper function to split bilingual content
                function splitBilingualContent(content) {
                    // Try to split by common patterns
                    var patterns = [
                        /(?:\n\n|\n|^)(?:English|الإنجليزية|الانجليزية|In English)/i,
                        /(?:\n\n|\n|^)(?:EN:|English:|الإنجليزية:|انجليزي:)/i
                    ];

                    for (var pattern of patterns) {
                        var parts = content.split(pattern);
                        if (parts.length >= 2) {
                            return {
                                ar: parts[0].trim(),
                                en: parts[1].trim()
                            };
                        }
                    }

                    return {
                        ar: content,
                        en: null
                    };
                }

                // Helper function to apply content to specific fields with TinyMCE support
                function applyToFields(content, lang, contentType) {
                    const fieldName = `long_desc_${lang}`;
                    console.log(`Applying content to field: ${fieldName}`);

                    // Update the textarea directly first
                    const $textarea = $(`textarea[name="${fieldName}"]`);
                    if ($textarea.length > 0) {
                        $textarea.val(content);
                        console.log(`Content applied to textarea ${fieldName}`);
                    } else {
                        console.error(`Textarea with name ${fieldName} not found!`);
                        return;
                    }

                    // Then try to update TinyMCE with multiple attempts
                    let attemptCount = 0;
                    const maxAttempts = 3;

                    function tryUpdateTinyMCE() {
                        attemptCount++;
                        console.log(`TinyMCE update attempt ${attemptCount} for ${fieldName}`);

                        if (typeof tinymce !== 'undefined') {
                            console.log('TinyMCE object exists');

                            // Approach 1: Try different possible editor IDs
                            const possibleIds = [
                                `tinymce_editor_0_${fieldName}`,
                                `tinymce_editor_1_${fieldName}`,
                                `tinymce_editor_2_${fieldName}`
                            ];

                            for (const editorId of possibleIds) {
                                try {
                                    const editor = tinymce.get(editorId);
                                    if (editor) {
                                        console.log(`Found editor with ID: ${editorId}`);
                                        editor.setContent(content);
                                        console.log('Content applied to TinyMCE editor successfully');
                                        return true;
                                    }
                                } catch (error) {
                                    console.log(`Editor ${editorId} not found`);
                                }
                            }

                            // Approach 2: Try by textarea ID
                            const textareaId = $textarea.attr('id');
                            if (textareaId) {
                                try {
                                    const editor = tinymce.get(textareaId);
                                    if (editor) {
                                        console.log(`Found editor with textarea ID: ${textareaId}`);
                                        editor.setContent(content);
                                        console.log('Content applied to TinyMCE editor successfully');
                                        return true;
                                    }
                                } catch (error) {
                                    console.log(`Editor with textarea ID ${textareaId} not found`);
                                }
                            }

                            // Approach 3: Check all active editors
                            if (tinymce.editors) {
                                console.log('tinymce.editors:', tinymce.editors);
                                console.log('Available editors keys:', Object.keys(tinymce.editors));

                                for (let editorId in tinymce.editors) {
                                    const editor = tinymce.editors[editorId];
                                    if (editor && editor.id && editor.id.includes(fieldName)) {
                                        try {
                                            console.log(`Found matching editor: ${editorId}`);
                                            editor.setContent(content);
                                            console.log('Content applied to TinyMCE editor successfully');
                                            return true;
                                        } catch (error) {
                                            console.error('Error setting TinyMCE content:', error);
                                        }
                                    }
                                }
                            } else {
                                console.log('tinymce.editors is undefined');
                            }
                        } else {
                            console.log(`TinyMCE not defined (attempt ${attemptCount})`);
                        }

                        // If not successful and we have attempts left, try again
                        if (attemptCount < maxAttempts) {
                            setTimeout(tryUpdateTinyMCE, 1000 * attemptCount);
                        } else {
                            console.log(`Failed to update TinyMCE after ${maxAttempts} attempts for ${fieldName}`);
                        }

                        return false;
                    }

                    // Start the TinyMCE update attempts
                    setTimeout(tryUpdateTinyMCE, 500);

                    // For SEO content, also apply to meta fields
                    if (contentType === 'seo_content') {
                        var firstSentence = content.replace(/<[^>]*>/g, '').split(/[.!?]+/)[0]; // Remove HTML tags
                        if (firstSentence && firstSentence.length > 10) {
                            $(`textarea[name="meta_desc_${lang}"]`).val(firstSentence + '.');
                            $(`textarea[name="meta_title_${lang}"]`).val(firstSentence);
                        }
                    }

                    // For detailed description, also apply short description
                    if (contentType === 'detailed_description') {
                        var plainText = content.replace(/<[^>]*>/g, ''); // Remove HTML tags
                        var sentences = plainText.split(/[.!?]+/).filter(s => s.trim());
                        if (sentences.length >= 2) {
                            var shortDesc = sentences.slice(0, 2).join('. ') + '.';
                            $(`textarea[name="short_desc_${lang}"]`).val(shortDesc);
                        }
                    }

                    // Trigger change event for any text editors
                    $(`textarea[name*="${lang}"]`).trigger('change');

                    console.log(`Content application completed for ${fieldName}`);
                }

                // Helper function to show status messages
                function showStatus(message, type) {
                    var alertClass = {
                        'success': 'alert-success',
                        'danger': 'alert-danger',
                        'warning': 'alert-warning',
                        'info': 'alert-info'
                    };

                    $('#aiGenerationStatus').html(`
                    <div class="alert ${alertClass[type]} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                    // Auto-hide success messages
                    if (type === 'success') {
                        setTimeout(function() {
                            $('#aiGenerationStatus').fadeOut();
                        }, 5000);
                    }
                }
            });
        </script>
    @endsection

</x-dashboard.layout>

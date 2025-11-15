<script src="{{ asset('assets/tinymce/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    // Initialize TinyMCE for all textareas with id="myeditorinstance" or ending with "_editor"
    document.addEventListener('DOMContentLoaded', function() {
        // Find all textareas with id="myeditorinstance" or IDs ending with "_editor"
        const textareas = document.querySelectorAll('textarea[id="myeditorinstance"], textarea[id$="_editor"]');

        textareas.forEach(function(textarea, index) {
            // Use existing ID if it ends with "_editor", otherwise create unique ID
            let uniqueId = textarea.id;
            if (!textarea.id.endsWith('_editor')) {
                uniqueId = 'tinymce_editor_' + index + '_' + textarea.name.replace(/[^a-zA-Z0-9]/g,
                    '_');
                textarea.id = uniqueId;
            }

            // Initialize TinyMCE for this specific textarea
            tinymce.init({
                selector: '#' + uniqueId,
                height: 500,
                branding: false,
                promotion: false,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
                    'codesample', 'pagebreak', 'nonbreaking', 'quickbars', 'accordion',
                    'visualchars', 'directionality'
                ],
                toolbar: [
                    'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor | ltr rtl | more',
                    'fontfamily fontsize | image | table | hr | code | help'
                ],
                toolbar_mode: 'sliding',
                contextmenu: 'link image imagetools table spellchecker configurepermanentpen',
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                quickbars_insert_toolbar: 'quickimage quicktable',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                visualchars_default_state: false,
                visualblocks_default_state: false,
                directionality: 'rtl',
                rtl_ui: true,
                // Image upload settings
                images_upload_url: '{{ route('dashboard.tinymce.upload-image') }}',
                images_upload_base_path: '',
                automatic_uploads: true,
                images_reuse_filename: false,
                images_upload_credentials: true,
                images_upload_handler: function(blobInfo, progress) {
                    return new Promise(function(resolve, reject) {
                        const xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;

                        xhr.upload.onprogress = function(e) {
                            progress(e.loaded / e.total * 100);
                        };

                        xhr.onload = function() {
                            if (xhr.status === 403) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }

                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }

                            const json = JSON.parse(xhr.responseText);

                            if (!json || typeof json.location != 'string') {
                                reject('Invalid JSON: ' + xhr.responseText);
                                return;
                            }

                            resolve(json.location);
                        };

                        xhr.onerror = function() {
                            reject('Image upload failed due to a XHR Transport error. Code: ' +
                                xhr.status);
                        };

                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo
                            .filename());
                        formData.append('_token', '{{ csrf_token() }}');

                        xhr.open('POST',
                            '{{ route('dashboard.tinymce.upload-image') }}');
                        xhr.send(formData);
                    });
                },
                setup: function(editor) {
                    editor.on('init', function() {
                        console.log('TinyMCE initialized for:', textarea.name,
                            'with ID:', uniqueId);
                    });

                    // Add custom button for toggling visual characters
                    editor.ui.registry.addToggleButton('visualchars', {
                        text: '¶',
                        tooltip: 'إظهار/إخفاء الرموز المخفية',
                        onAction: function(api) {
                            editor.execCommand('mceVisualChars');
                            api.setActive(!api.isActive());
                        }
                    });

                    // Add custom button for toggling visual blocks
                    editor.ui.registry.addToggleButton('visualblocks', {
                        text: '◈',
                        tooltip: 'إظهار/إخفاء الكتل المرئية',
                        onAction: function(api) {
                            editor.execCommand('mceVisualBlocks');
                            api.setActive(!api.isActive());
                        }
                    });

                    // Add custom button for RTL direction
                    editor.ui.registry.addButton('rtl', {
                        text: '¶<',
                        tooltip: 'اتجاه النص من اليمين إلى اليسار (RTL)',
                        onAction: function() {
                            editor.execCommand('mceDirectionRTL');
                        }
                    });

                    // Add custom button for LTR direction
                    editor.ui.registry.addButton('ltr', {
                        text: '>¶',
                        tooltip: 'اتجاه النص من اليسار إلى اليمين (LTR)',
                        onAction: function() {
                            editor.execCommand('mceDirectionLTR');
                        }
                    });

                    // Add custom dropdown menu with all tools
                    editor.ui.registry.addMenuButton('more', {
                        text: '...',
                        icon: 'more-drawer',
                        tooltip: 'المزيد من الأدوات',
                        fetch: function(callback) {
                            var items = [{
                                    type: 'menuitem',
                                    text: 'إزالة التنسيق',
                                    icon: 'removeformat',
                                    onAction: function() {
                                        editor.execCommand(
                                            'RemoveFormat');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'لون الخلفية',
                                    icon: 'backcolor',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceColorPicker', false,
                                            'backcolor');
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إظهار/إخفاء الرموز المخفية',
                                    icon: 'visualchars',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceVisualChars');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إظهار/إخفاء الكتل المرئية',
                                    icon: 'visualblocks',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceVisualBlocks');
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'اتجاه RTL (من اليمين إلى اليسار)',
                                    icon: 'rtl',
                                    onAction: function() {
                                        var selectedNode = editor
                                            .selection.getNode();
                                        var element = selectedNode;

                                        // Find the closest block element
                                        while (element && !editor.dom
                                            .isBlock(element)) {
                                            element = element
                                                .parentNode;
                                        }

                                        if (element && element !==
                                            editor.getBody()) {
                                            editor.dom.setStyle(element,
                                                'direction', 'rtl');
                                            editor.dom.setStyle(element,
                                                'text-align',
                                                'right');
                                        } else {
                                            // Apply to selected text or current paragraph
                                            var content = editor
                                                .selection.getContent();
                                            if (content) {
                                                editor.selection
                                                    .setContent(
                                                        '<span style="direction: rtl; text-align: right;">' +
                                                        content +
                                                        '</span>');
                                            } else {
                                                editor.execCommand(
                                                    'mceInsertContent',
                                                    false,
                                                    '<p style="direction: rtl; text-align: right;">نص من اليمين إلى اليسار</p>'
                                                );
                                            }
                                        }
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'اتجاه LTR (من اليسار إلى اليمين)',
                                    icon: 'ltr',
                                    onAction: function() {
                                        var selectedNode = editor
                                            .selection.getNode();
                                        var element = selectedNode;

                                        // Find the closest block element
                                        while (element && !editor.dom
                                            .isBlock(element)) {
                                            element = element
                                                .parentNode;
                                        }

                                        if (element && element !==
                                            editor.getBody()) {
                                            editor.dom.setStyle(element,
                                                'direction', 'ltr');
                                            editor.dom.setStyle(element,
                                                'text-align', 'left'
                                            );
                                        } else {
                                            // Apply to selected text or current paragraph
                                            var content = editor
                                                .selection.getContent();
                                            if (content) {
                                                editor.selection
                                                    .setContent(
                                                        '<span style="direction: ltr; text-align: left;">' +
                                                        content +
                                                        '</span>');
                                            } else {
                                                editor.execCommand(
                                                    'mceInsertContent',
                                                    false,
                                                    '<p style="direction: ltr; text-align: left;">Text from left to right</p>'
                                                );
                                            }
                                        }
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج جدول',
                                    icon: 'table',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceInsertTable');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج صورة',
                                    icon: 'image',
                                    onAction: function() {
                                        editor.execCommand('mceImage');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج فيديو',
                                    icon: 'video',
                                    onAction: function() {
                                        editor.windowManager.open({
                                            title: 'إدراج فيديو',
                                            body: {
                                                type: 'panel',
                                                items: [{
                                                        type: 'input',
                                                        name: 'url',
                                                        label: 'رابط الفيديو (YouTube, Vimeo, ملف مباشر)',
                                                        placeholder: 'https://www.youtube.com/watch?v=...'
                                                    },
                                                    {
                                                        type: 'input',
                                                        name: 'width',
                                                        label: 'العرض',
                                                        value: '560'
                                                    },
                                                    {
                                                        type: 'input',
                                                        name: 'height',
                                                        label: 'الارتفاع',
                                                        value: '315'
                                                    },
                                                    {
                                                        type: 'checkbox',
                                                        name: 'responsive',
                                                        label: 'تصميم متجاوب'
                                                    },
                                                    {
                                                        type: 'checkbox',
                                                        name: 'autoplay',
                                                        label: 'تشغيل تلقائي'
                                                    }
                                                ]
                                            },
                                            buttons: [{
                                                    type: 'cancel',
                                                    text: 'إلغاء'
                                                },
                                                {
                                                    type: 'submit',
                                                    text: 'إدراج',
                                                    primary: true
                                                }
                                            ],
                                            onSubmit: function(
                                                api) {
                                                var data =
                                                    api
                                                    .getData();
                                                var videoUrl =
                                                    data
                                                    .url;
                                                var width =
                                                    data
                                                    .width ||
                                                    '560';
                                                var height =
                                                    data
                                                    .height ||
                                                    '315';
                                                var responsive =
                                                    data
                                                    .responsive;
                                                var autoplay =
                                                    data
                                                    .autoplay;

                                                if (
                                                    videoUrl
                                                ) {
                                                    var embedCode =
                                                        '';
                                                    var autoplayParam =
                                                        autoplay ?
                                                        '&autoplay=1' :
                                                        '';

                                                    // YouTube
                                                    if (videoUrl
                                                        .includes(
                                                            'youtube.com'
                                                        ) ||
                                                        videoUrl
                                                        .includes(
                                                            'youtu.be'
                                                        )) {
                                                        var videoId =
                                                            '';
                                                        if (videoUrl
                                                            .includes(
                                                                'youtube.com/watch?v='
                                                            )
                                                        ) {
                                                            videoId
                                                                =
                                                                videoUrl
                                                                .split(
                                                                    'v='
                                                                )[
                                                                    1
                                                                ]
                                                                .split(
                                                                    '&'
                                                                )[
                                                                    0
                                                                ];
                                                        } else if (
                                                            videoUrl
                                                            .includes(
                                                                'youtu.be/'
                                                            )
                                                        ) {
                                                            videoId
                                                                =
                                                                videoUrl
                                                                .split(
                                                                    'youtu.be/'
                                                                )[
                                                                    1
                                                                ]
                                                                .split(
                                                                    '?'
                                                                )[
                                                                    0
                                                                ];
                                                        }

                                                        if (
                                                            responsive
                                                        ) {
                                                            embedCode
                                                                =
                                                                '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">';
                                                            embedCode
                                                                +=
                                                                '<iframe src="https://www.youtube.com/embed/' +
                                                                videoId +
                                                                '?rel=0' +
                                                                autoplayParam +
                                                                '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>';
                                                            embedCode
                                                                +=
                                                                '</div>';
                                                        } else {
                                                            embedCode
                                                                =
                                                                '<iframe width="' +
                                                                width +
                                                                '" height="' +
                                                                height +
                                                                '" src="https://www.youtube.com/embed/' +
                                                                videoId +
                                                                '?rel=0' +
                                                                autoplayParam +
                                                                '" frameborder="0" allowfullscreen></iframe>';
                                                        }
                                                    }
                                                    // Vimeo
                                                    else if (
                                                        videoUrl
                                                        .includes(
                                                            'vimeo.com'
                                                        )) {
                                                        var videoId =
                                                            videoUrl
                                                            .split(
                                                                'vimeo.com/'
                                                            )[
                                                                1
                                                            ]
                                                            .split(
                                                                '?'
                                                            )[
                                                                0
                                                            ];
                                                        var vimeoAutoplay =
                                                            autoplay ?
                                                            '&autoplay=1' :
                                                            '';

                                                        if (
                                                            responsive
                                                        ) {
                                                            embedCode
                                                                =
                                                                '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">';
                                                            embedCode
                                                                +=
                                                                '<iframe src="https://player.vimeo.com/video/' +
                                                                videoId +
                                                                '?title=0&byline=0&portrait=0' +
                                                                vimeoAutoplay +
                                                                '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>';
                                                            embedCode
                                                                +=
                                                                '</div>';
                                                        } else {
                                                            embedCode
                                                                =
                                                                '<iframe width="' +
                                                                width +
                                                                '" height="' +
                                                                height +
                                                                '" src="https://player.vimeo.com/video/' +
                                                                videoId +
                                                                '?title=0&byline=0&portrait=0' +
                                                                vimeoAutoplay +
                                                                '" frameborder="0" allowfullscreen></iframe>';
                                                        }
                                                    }
                                                    // Direct video file
                                                    else if (
                                                        videoUrl
                                                        .match(
                                                            /\.(mp4|webm|ogg|mov|avi)$/i
                                                        )) {
                                                        var autoplayAttr =
                                                            autoplay ?
                                                            'autoplay' :
                                                            '';

                                                        if (
                                                            responsive
                                                        ) {
                                                            embedCode
                                                                =
                                                                '<div style="position: relative; width: 100%; max-width: ' +
                                                                width +
                                                                'px;">';
                                                            embedCode
                                                                +=
                                                                '<video controls ' +
                                                                autoplayAttr +
                                                                ' style="width: 100%; height: auto;"><source src="' +
                                                                videoUrl +
                                                                '" type="video/mp4">متصفحك لا يدعم تشغيل الفيديو.</video>';
                                                            embedCode
                                                                +=
                                                                '</div>';
                                                        } else {
                                                            embedCode
                                                                =
                                                                '<video width="' +
                                                                width +
                                                                '" height="' +
                                                                height +
                                                                '" controls ' +
                                                                autoplayAttr +
                                                                '><source src="' +
                                                                videoUrl +
                                                                '" type="video/mp4">متصفحك لا يدعم تشغيل الفيديو.</video>';
                                                        }
                                                    }
                                                    // Generic iframe (for other platforms)
                                                    else {
                                                        if (
                                                            responsive
                                                        ) {
                                                            embedCode
                                                                =
                                                                '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">';
                                                            embedCode
                                                                +=
                                                                '<iframe src="' +
                                                                videoUrl +
                                                                '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>';
                                                            embedCode
                                                                +=
                                                                '</div>';
                                                        } else {
                                                            embedCode
                                                                =
                                                                '<iframe width="' +
                                                                width +
                                                                '" height="' +
                                                                height +
                                                                '" src="' +
                                                                videoUrl +
                                                                '" frameborder="0" allowfullscreen></iframe>';
                                                        }
                                                    }

                                                    editor
                                                        .insertContent(
                                                            embedCode
                                                        );
                                                    api
                                                        .close();
                                                } else {
                                                    editor
                                                        .windowManager
                                                        .alert(
                                                            'يرجى إدخال رابط الفيديو'
                                                        );
                                                }
                                            }
                                        });
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج رابط',
                                    icon: 'link',
                                    onAction: function() {
                                        editor.execCommand('mceLink');
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج رمز تعبيري',
                                    icon: 'emoticons',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceEmoticons');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج رمز خاص',
                                    icon: 'charmap',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceCharMap');
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'كود المصدر',
                                    icon: 'code',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceCodeEditor');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'معاينة كاملة الشاشة',
                                    icon: 'fullscreen',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceFullScreen');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'معاينة',
                                    icon: 'preview',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mcePreview');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'طباعة',
                                    icon: 'print',
                                    onAction: function() {
                                        editor.execCommand('mcePrint');
                                    }
                                },
                                {
                                    type: 'separator'
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج فاصل صفحة',
                                    icon: 'pagebreak',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mcePageBreak');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج فاصل',
                                    icon: 'hr',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceInsertHorizontalRule'
                                        );
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'إدراج كود',
                                    icon: 'codesample',
                                    onAction: function() {
                                        editor.execCommand(
                                            'mceCodeSample');
                                    }
                                }
                            ];
                            callback(items);
                        }
                    });
                }
            });
        });
    });
</script>

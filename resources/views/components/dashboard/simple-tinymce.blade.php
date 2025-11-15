<script src="{{ asset('assets/tinymce/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find all textareas with IDs ending with "_editor"
        const textareas = document.querySelectorAll('textarea[id$="_editor"]');

        textareas.forEach(function(textarea, index) {
            const uniqueId = textarea.id;

            // Initialize TinyMCE with minimal config
            tinymce.init({
                selector: '#' + uniqueId,
                height: 300,
                branding: false,
                promotion: false,
                menubar: false,
                plugins: ['lists', 'link', 'table', 'directionality'],
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | ltr rtl',
                content_style: 'body { font-family:Arial,sans-serif; font-size:14px }',
                directionality: 'rtl',
                setup: function(editor) {
                    editor.on('init', function() {
                        console.log('TinyMCE initialized for:', uniqueId);
                    });
                }
            });
        });
    });
</script>
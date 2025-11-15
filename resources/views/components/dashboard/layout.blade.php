<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? config('app.name', 'Dashboard') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Path::FavIcon() }}" type="image/x-icon" />

    <!-- Css -->
    <x-dashboard.partials.css />

    <!--TinyMCE  script -->
    <x-dashboard.tinymce-config />

    <!-- Page specific styles -->
    @stack('styles')

    {{-- Google Tag Manager --}}
    @if (config('settings.google_tag_manager_id'))
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ config('
            settings.google_tag_manager_id ') }}');
    </script>
    @endif
    {{-- End Google Tag Manager --}}

</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <x-dashboard.partials.header />

        <!-- ========== Left Sidebar Start ========== -->
        <x-dashboard.partials.left-sidebar />
        <!-- Left Sidebar End -->


        <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <x-dashboard.partials.right-sidebar />
        <!-- /Right-bar -->

    </div>

    <!-- JAVASCRIPT -->

    <x-dashboard.partials.script />

    @stack('scripts')

    <!-- Required Fields Styling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to apply required field styling
            function applyRequiredFieldStyling() {
                // Get current language
                const currentLang = document.documentElement.lang || 'ar';
                const isArabic = currentLang === 'ar';

                // Required text based on language
                const requiredText = isArabic ? 'مطلوب' : 'Required';
                const requiredColor = '#dc3545'; // Bootstrap danger color

                // Find all required inputs
                const requiredInputs = document.querySelectorAll(
                    'input[required], select[required], textarea[required]');

                requiredInputs.forEach(function(input) {
                    // Add red border to required inputs
                    input.style.borderColor = requiredColor;
                    input.style.borderWidth = '2px';

                    // Find the label for this input
                    let label = null;

                    // Try different ways to find the label
                    if (input.id) {
                        label = document.querySelector(`label[for="${input.id}"]`);
                    }

                    if (!label) {
                        // Look for label in the same form-group or parent container
                        const container = input.closest('.form-group, .mb-3, [class*="col-"]');
                        if (container) {
                            label = container.querySelector('label');
                        }
                    }

                    if (!label) {
                        // Look for previous sibling label
                        let sibling = input.previousElementSibling;
                        while (sibling) {
                            if (sibling.tagName === 'LABEL') {
                                label = sibling;
                                break;
                            }
                            sibling = sibling.previousElementSibling;
                        }
                    }

                    // If label found, add required indicator
                    if (label && !label.querySelector('.required-indicator')) {
                        const requiredSpan = document.createElement('span');
                        requiredSpan.className = 'required-indicator';
                        requiredSpan.style.color = requiredColor;
                        requiredSpan.style.fontWeight = 'bold';
                        requiredSpan.style.marginLeft = '5px';
                        requiredSpan.textContent = ` (${requiredText})`;

                        label.appendChild(requiredSpan);
                    }

                    // Add focus/blur events to enhance the styling
                    input.addEventListener('focus', function() {
                        this.style.boxShadow = `0 0 0 0.2rem rgba(220, 53, 69, 0.25)`;
                    });

                    input.addEventListener('blur', function() {
                        if (!this.value.trim()) {
                            this.style.borderColor = requiredColor;
                            this.style.boxShadow = 'none';
                        } else {
                            this.style.borderColor = '#28a745'; // Green when filled
                            this.style.boxShadow = 'none';
                        }
                    });

                    // Add input event to change border color when typing
                    input.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.style.borderColor = '#28a745'; // Green when filled
                        } else {
                            this.style.borderColor = requiredColor; // Red when empty
                        }
                    });
                });
            }

            // Apply styling immediately
            applyRequiredFieldStyling();

            // Also apply after delays to catch dynamically loaded content
            setTimeout(applyRequiredFieldStyling, 100);
            setTimeout(applyRequiredFieldStyling, 500);
            setTimeout(applyRequiredFieldStyling, 1000);

            // Watch for dynamically added content
            const observer = new MutationObserver(function(mutations) {
                let shouldReapply = false;
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && (
                                    node.matches && node.matches(
                                        'input[required], select[required], textarea[required]'
                                    ) ||
                                    node.querySelector && node.querySelector(
                                        'input[required], select[required], textarea[required]'
                                    )
                                )) {
                                shouldReapply = true;
                            }
                        });
                    }
                });

                if (shouldReapply) {
                    setTimeout(applyRequiredFieldStyling, 100);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Make function globally available
            window.applyRequiredFieldStyling = applyRequiredFieldStyling;
        });
    </script>

    {{-- Google Tag Manager (noscript) --}}
    @if (config('settings.google_tag_manager_id'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('settings.google_tag_manager_id') }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    {{-- End Google Tag Manager (noscript) --}}
</body>

</html>
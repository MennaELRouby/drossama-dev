// Dark Mode Script for All Pages
(function () {
    'use strict';

    // Dark Mode Functions
    function enableDarkMode() {
        document.body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
    }

    function disableDarkMode() {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
    }

    // Check for saved dark mode preference
    function initDarkMode() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            enableDarkMode();
        } else {
            enableDarkMode(); // Force dark mode for all pages
        }
    }

    // Initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDarkMode);
    } else {
        initDarkMode();
    }

    // Add dark mode styles if not already present
    function addDarkModeStyles() {
        if (!document.getElementById('dark-mode-styles')) {
            const style = document.createElement('style');
            style.id = 'dark-mode-styles';
            style.textContent = `
                /* Dark Mode Enhancements */
                body {
                    background-color: #171717 !important;
                    color: #ffffff !important;
                }
                
                .page-wrapper {
                    background-color: #171717 !important;
                }
                
                section {
                    background-color: #171717 !important;
                }
                
                .header-style-one,
                .header-style-two,
                .header-style-three,
                .header-style-four {
                    background-color: #171717 !important;
                    border-bottom: 1px solid #333 !important;
                }
                
                .about-section,
                .services-section,
                .testimonial-section,
                .gallery-section,
                .contact-section {
                    background-color: #171717 !important;
                }
                
                .footer-style-one,
                .footer-style-two {
                    background-color: #0f0f0f !important;
                }
                
                .theme-btn {
                    background-color: #4b92fe !important;
                    color: white !important;
                }
                
                .theme-btn:hover {
                    background-color: #357abd !important;
                }
                
                h1, h2, h3, h4, h5, h6 {
                    color: #ffffff !important;
                }
                
                p, span, div {
                    color: #e0e0e0 !important;
                }
                
                .card, .inner-box, .content-box {
                    background-color: #222020 !important;
                    border: 1px solid #333 !important;
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Add styles when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', addDarkModeStyles);
    } else {
        addDarkModeStyles();
    }
})();

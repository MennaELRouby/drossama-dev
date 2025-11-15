{{-- PWA Install Prompt Component --}}
<div id="pwa-install-prompt" class="pwa-install-prompt" style="display: none;">
    <div class="pwa-prompt-content">
        <div class="pwa-prompt-header">
            <div class="pwa-prompt-logo">
                <img src="{{ Path::AppLogo('site_logo') }}" alt="{{ Path::AppName('site_name') }}">
            </div>
            <button class="pwa-prompt-close" onclick="hidePWAPrompt()">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div class="pwa-prompt-body">
            <h3 class="pwa-prompt-title">
                @if (app()->getLocale() == 'ar')
                    تثبيت التطبيق
                @elseif(app()->getLocale() == 'en')
                    Install App
                @elseif(app()->getLocale() == 'fr')
                    Installer l'application
                @elseif(app()->getLocale() == 'de')
                    App installieren
                @else
                    Install App
                @endif
            </h3>

            <div class="pwa-prompt-info">
                <div class="pwa-prompt-site-name">{{ Path::AppName('site_name') }}</div>
                <div class="pwa-prompt-site-url">{{ request()->getHost() }}</div>
            </div>

            <p class="pwa-prompt-description">
                @if (app()->getLocale() == 'ar')
                    ثبت التطبيق على جهازك للوصول السريع وتجربة أفضل
                @elseif(app()->getLocale() == 'en')
                    Install the app on your device for quick access and better experience
                @elseif(app()->getLocale() == 'fr')
                    Installez l'application sur votre appareil pour un accès rapide et une meilleure expérience
                @elseif(app()->getLocale() == 'de')
                    Installieren Sie die App auf Ihrem Gerät für schnellen Zugriff und bessere Erfahrung
                @else
                    Install the app on your device for quick access and better experience
                @endif
            </p>

            <div class="pwa-site-description">
                <small>{{ strip_tags(config('configrations.site_description', '')) }}</small>
            </div>
        </div>

        <div class="pwa-prompt-actions">
            <button class="pwa-btn pwa-btn-cancel" onclick="hidePWAPrompt()">
                @if (app()->getLocale() == 'ar')
                    إلغاء
                @elseif(app()->getLocale() == 'en')
                    Cancel
                @elseif(app()->getLocale() == 'fr')
                    Annuler
                @elseif(app()->getLocale() == 'de')
                    Abbrechen
                @else
                    Cancel
                @endif
            </button>
            <button class="pwa-btn pwa-btn-install" onclick="installPWA()">
                @if (app()->getLocale() == 'ar')
                    تثبيت
                @elseif(app()->getLocale() == 'en')
                    Install
                @elseif(app()->getLocale() == 'fr')
                    Installer
                @elseif(app()->getLocale() == 'de')
                    Installieren
                @else
                    Install
                @endif
            </button>
        </div>
    </div>
</div>

<style>
    .pwa-install-prompt {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .pwa-prompt-content {
        background: white;
        border-radius: 16px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: pwaPromptSlideIn 0.3s ease-out;
    }

    @keyframes pwaPromptSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .pwa-prompt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 20px 0 20px;
    }

    .pwa-prompt-logo img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: contain;
    }

    .pwa-prompt-close {
        background: none;
        border: none;
        font-size: 18px;
        color: #666;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pwa-prompt-close:hover {
        background: #f0f0f0;
    }

    .pwa-prompt-body {
        padding: 20px;
        text-align: center;
    }

    .pwa-prompt-title {
        margin: 0 0 15px 0;
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .pwa-prompt-info {
        margin-bottom: 15px;
    }

    .pwa-prompt-site-name {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    .pwa-prompt-site-url {
        font-size: 14px;
        color: #666;
    }

    .pwa-prompt-description {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #666;
        line-height: 1.5;
    }

    .pwa-site-description {
        margin: 0;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #007bff;
    }

    .pwa-site-description small {
        font-size: 12px;
        color: #555;
        line-height: 1.4;
    }

    .pwa-prompt-actions {
        display: flex;
        gap: 10px;
        padding: 20px;
        border-top: 1px solid #eee;
    }

    .pwa-btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pwa-btn-cancel {
        background: #f5f5f5;
        color: #333;
    }

    .pwa-btn-cancel:hover {
        background: #e5e5e5;
    }

    .pwa-btn-install {
        background: #007bff;
        color: white;
    }

    .pwa-btn-install:hover {
        background: #0056b3;
    }

    /* RTL Support */
    [dir="rtl"] .pwa-prompt-header {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .pwa-prompt-actions {
        flex-direction: row-reverse;
    }

    /* Mobile Responsive */
    @media (max-width: 480px) {
        .pwa-install-prompt {
            padding: 10px;
        }

        .pwa-prompt-content {
            max-width: 100%;
        }

        .pwa-prompt-title {
            font-size: 20px;
        }

        .pwa-btn {
            font-size: 14px;
            padding: 10px 15px;
        }
    }
</style>

<script>
    let deferredPrompt;
    let isPWAInstalled = false;

    // Check if PWA is already installed
    function checkPWAInstallation() {
        // Check if running as PWA
        if (window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone === true) {
            isPWAInstalled = true;
            return true;
        }

        // Check if already installed by checking localStorage
        const installed = localStorage.getItem('pwa_installed');
        if (installed === 'true') {
            isPWAInstalled = true;
            return true;
        }

        return false;
    }

    // Show PWA install prompt
    function showPWAPrompt() {
        if (checkPWAInstallation()) {
            return; // Don't show if already installed
        }

        // Check if user dismissed the prompt recently
        const dismissedTime = localStorage.getItem('pwa_prompt_dismissed');
        const now = Date.now();

        // Show prompt if not dismissed or dismissed more than 7 days ago
        if (!dismissedTime || (now - parseInt(dismissedTime)) > (7 * 24 * 60 * 60 * 1000)) {
            const promptElement = document.getElementById('pwa-install-prompt');
            if (promptElement) {
                promptElement.style.display = 'flex';
            }
        }
    }

    // Hide PWA install prompt
    function hidePWAPrompt() {
        const promptElement = document.getElementById('pwa-install-prompt');
        if (promptElement) {
            promptElement.style.display = 'none';
        }

        // Store dismissal time
        localStorage.setItem('pwa_prompt_dismissed', Date.now().toString());
    }

    // Install PWA
    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();

            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('PWA installation accepted');
                    localStorage.setItem('pwa_installed', 'true');
                    isPWAInstalled = true;
                } else {
                    console.log('PWA installation dismissed');
                    localStorage.setItem('pwa_prompt_dismissed', Date.now().toString());
                }
                deferredPrompt = null;
                hidePWAPrompt();
            });
        } else {
            // Fallback for browsers that don't support beforeinstallprompt
            hidePWAPrompt();

            // Show manual installation instructions
            if (app().getLocale() === 'ar') {
                alert(
                    'لتثبيت التطبيق: انقر على القائمة (⋮) في المتصفح واختر "تثبيت التطبيق" أو "إضافة إلى الشاشة الرئيسية"'
                );
            } else {
                alert(
                    'To install the app: Click the menu (⋮) in your browser and select "Install app" or "Add to Home Screen"'
                );
            }
        }
    }

    // Listen for beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('PWA install prompt available');
        e.preventDefault();
        deferredPrompt = e;

        // Show prompt after 3 seconds
        setTimeout(() => {
            showPWAPrompt();
        }, 3000);
    });

    // Listen for appinstalled event
    window.addEventListener('appinstalled', (e) => {
        console.log('PWA installed successfully');
        localStorage.setItem('pwa_installed', 'true');
        isPWAInstalled = true;
        hidePWAPrompt();
    });

    // Check installation status on page load
    document.addEventListener('DOMContentLoaded', function() {
        checkPWAInstallation();
    });

    // Track install prompt events for analytics
    function trackPWAPromptEvent(action) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'pwa_prompt_' + action, {
                'event_category': 'PWA',
                'event_label': window.location.pathname
            });
        }
    }

    // Track when prompt is shown
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('pwa-btn-install')) {
            trackPWAPromptEvent('install_clicked');
        } else if (e.target.classList.contains('pwa-btn-cancel') ||
            e.target.classList.contains('pwa-prompt-close')) {
            trackPWAPromptEvent('dismissed');
        }
    });
</script>

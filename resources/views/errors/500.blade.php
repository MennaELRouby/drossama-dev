@php
    // Get dynamic data
    $phones = collect();
    $site_addresses = collect();
    $settings = [];

    try {
        $phones = \App\Models\Phone::active()->orderBy('order')->get();
        $site_addresses = \App\Models\SiteAddress::active()->orderBy('order')->get();

        // Get settings
        $settingsData = \App\Models\Setting::whereIn('key', [
            'site_name',
            'site_phone',
            'site_whatsapp',
            'site_email',
            'site_facebook',
            'site_instagram',
            'site_twitter',
            'site_linkedin',
            'site_youtube',
            'site_tiktok',
            'site_snapchat',
            'site_telegram',
        ])->get();

        foreach ($settingsData as $setting) {
            $settings[$setting->key] = $setting->value;
        }
    } catch (\Exception $e) {
        // If database is not available, use defaults
        $settings = [
            'site_name' => config('app.name', 'الموقع'),
            'site_phone' => null,
            'site_whatsapp' => null,
            'site_email' => null,
        ];
    }

    $siteName = $settings['site_name'] ?? config('app.name', 'الموقع');
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في الخادم - {{ $siteName }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            direction: rtl;
            text-align: center;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            max-width: 600px;
            width: 90%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .error-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .error-details {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: right;
            font-family: monospace;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin: 2rem 0;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #495057);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .help-section {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
            text-align: right;
        }

        .help-section h3 {
            margin-bottom: 1rem;
            color: #ffc107;
        }

        .help-list {
            list-style: none;
            padding: 0;
        }

        .help-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .help-list li:last-child {
            border-bottom: none;
        }

        .timestamp {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 1rem;
        }

        /* Contact Section Styles */
        .contact-section {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
        }

        .contact-section h3 {
            margin-bottom: 1.5rem;
            color: #ffc107;
            font-size: 1.3rem;
        }

        .contact-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .contact-btn {
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            color: white;
            border: 2px solid transparent;
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-whatsapp {
            background: linear-gradient(45deg, #25D366, #128C7E);
        }

        .btn-whatsapp:hover {
            background: linear-gradient(45deg, #128C7E, #075E54);
        }

        .btn-phone {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .btn-phone:hover {
            background: linear-gradient(45deg, #0056b3, #003d82);
        }

        .btn-email {
            background: linear-gradient(45deg, #dc3545, #c82333);
        }

        .btn-email:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
        }

        /* Social Media Icons */
        .social-media {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-media h4 {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: #fff;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .social-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .social-facebook {
            background: linear-gradient(45deg, #1877f2, #0d5dba);
        }

        .social-instagram {
            background: linear-gradient(45deg, #E4405F, #C13584);
        }

        .social-twitter {
            background: linear-gradient(45deg, #1DA1F2, #0d8bd9);
        }

        .social-linkedin {
            background: linear-gradient(45deg, #0077B5, #005885);
        }

        .social-youtube {
            background: linear-gradient(45deg, #FF0000, #cc0000);
        }

        .social-tiktok {
            background: linear-gradient(45deg, #000000, #333333);
        }

        .social-snapchat {
            background: linear-gradient(45deg, #FFFC00, #ccca00);
        }

        .social-telegram {
            background: linear-gradient(45deg, #0088cc, #006699);
        }

        /* Branches Section */
        .branches-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .branches-section h4 {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: #fff;
        }

        .branch-item {
            background: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.8rem;
            text-align: right;
        }

        .branch-item strong {
            color: #ffc107;
            display: block;
            margin-bottom: 0.3rem;
        }

        .branch-item p {
            margin: 0.3rem 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 2rem;
                margin: 1rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-actions {
                flex-direction: column;
                align-items: center;
            }

            .contact-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .contact-btn {
                width: 100%;
                justify-content: center;
            }

            .social-links {
                gap: 0.8rem;
            }

            .social-link {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">🚨</div>
        <h1 class="error-title">خطأ في الخادم</h1>
        <p class="error-message">
            عذراً، حدث خطأ غير متوقع في الخادم. نحن نعمل على حل هذه المشكلة.
        </p>

        @if (config('app.debug') && isset($exception))
            <div class="error-details">
                <strong>تفاصيل الخطأ:</strong><br>
                <strong>الملف:</strong> {{ $exception->getFile() }}<br>
                <strong>السطر:</strong> {{ $exception->getLine() }}<br>
                <strong>الرسالة:</strong> {{ $exception->getMessage() }}<br>
                @if ($exception->getCode())
                    <strong>الكود:</strong> {{ $exception->getCode() }}<br>
                @endif
            </div>
        @else
            <div class="error-details">
                <strong>معرف الخطأ:</strong> {{ uniqid('ERR_') }}<br>
                <strong>الوقت:</strong> {{ now()->format('Y-m-d H:i:s') }}<br>
                <strong>الصفحة:</strong> {{ request()->fullUrl() }}
            </div>
        @endif
        {{-- Contact Section --}}
        <div class="contact-section">
            <h3>📞 تواصل معنا</h3>

            <div class="contact-buttons">
                @if (!empty($settings['site_whatsapp']))
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['site_whatsapp']) }}"
                        class="contact-btn btn-whatsapp" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        واتساب
                    </a>
                @endif

                @if (!empty($settings['site_phone']))
                    <a href="tel:{{ $settings['site_phone'] }}" class="contact-btn btn-phone">
                        <i class="fas fa-phone"></i>
                        اتصل بنا
                    </a>
                @endif

                @if (!empty($settings['site_email']))
                    <a href="mailto:{{ $settings['site_email'] }}" class="contact-btn btn-email">
                        <i class="fas fa-envelope"></i>
                        راسلنا
                    </a>
                @endif
            </div>

            {{-- Branches Section --}}
            @if ($site_addresses && $site_addresses->count() > 0)
                <div class="branches-section">
                    <h4>📍 فروعنا</h4>
                    @foreach ($site_addresses->take(3) as $address)
                        <div class="branch-item">
                            <strong>{{ $address->title }}</strong>
                            <p>📌 {{ $address->address }}</p>
                            @if ($address->phone)
                                <p>
                                    <a href="tel:{{ $address->phone }}" style="color: #ffc107; text-decoration: none;">
                                        📞 {{ $address->phone }}
                                    </a>
                                    |
                                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $address->phone) }}"
                                        style="color: #25D366; text-decoration: none;" target="_blank">
                                        <i class="fab fa-whatsapp"></i> واتساب
                                    </a>
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Social Media Links --}}
            @if (
                !empty($settings['site_facebook']) ||
                    !empty($settings['site_instagram']) ||
                    !empty($settings['site_twitter']) ||
                    !empty($settings['site_linkedin']) ||
                    !empty($settings['site_youtube']) ||
                    !empty($settings['site_tiktok']))
                <div class="social-media">
                    <h4>🌐 تابعنا على</h4>
                    <div class="social-links">
                        @if (!empty($settings['site_facebook']))
                            <a href="{{ $settings['site_facebook'] }}" class="social-link social-facebook"
                                target="_blank" rel="noopener noreferrer" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_instagram']))
                            <a href="{{ $settings['site_instagram'] }}" class="social-link social-instagram"
                                target="_blank" rel="noopener noreferrer" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_twitter']))
                            <a href="{{ $settings['site_twitter'] }}" class="social-link social-twitter"
                                target="_blank" rel="noopener noreferrer" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_linkedin']))
                            <a href="{{ $settings['site_linkedin'] }}" class="social-link social-linkedin"
                                target="_blank" rel="noopener noreferrer" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_youtube']))
                            <a href="{{ $settings['site_youtube'] }}" class="social-link social-youtube"
                                target="_blank" rel="noopener noreferrer" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_tiktok']))
                            <a href="{{ $settings['site_tiktok'] }}" class="social-link social-tiktok" target="_blank"
                                rel="noopener noreferrer" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_snapchat']))
                            <a href="{{ $settings['site_snapchat'] }}" class="social-link social-snapchat"
                                target="_blank" rel="noopener noreferrer" title="Snapchat">
                                <i class="fab fa-snapchat-ghost"></i>
                            </a>
                        @endif

                        @if (!empty($settings['site_telegram']))
                            <a href="{{ $settings['site_telegram'] }}" class="social-link social-telegram"
                                target="_blank" rel="noopener noreferrer" title="Telegram">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="error-actions">
            <button class="btn btn-primary" onclick="window.location.reload()">
                🔄 إعادة المحاولة
            </button>
            <a href="/" class="btn btn-success">
                🏠 العودة للرئيسية
            </a>
            <button class="btn btn-secondary" onclick="history.back()">
                ⬅️ العودة للخلف
            </button>
        </div>

        <div class="help-section">
            <h3>💡 ماذا يمكنك فعله؟</h3>
            <ul class="help-list">
                <li>🔄 أعد تحميل الصفحة - قد تكون مشكلة مؤقتة</li>
                <li>⏰ انتظر بضع دقائق وحاول مرة أخرى</li>
                <li>🏠 عد للصفحة الرئيسية وجرب مسار آخر</li>
                <li>📞 تواصل معنا إذا استمرت المشكلة</li>
            </ul>
        </div>



        <div class="timestamp">
            🕒 {{ now()->format('Y-m-d H:i:s') }}
        </div>
    </div>

    <script>
        // Auto-refresh after 30 seconds if not in debug mode
        @if (!config('app.debug'))
            setTimeout(() => {
                if (confirm('هل تريد إعادة المحاولة تلقائياً؟')) {
                    window.location.reload();
                }
            }, 30000);
        @endif

        // Log error for tracking
        console.error('🚨 Server Error 500:', {
            url: window.location.href,
            timestamp: new Date().toISOString(),
            userAgent: navigator.userAgent
        });
    </script>
</body>

</html>

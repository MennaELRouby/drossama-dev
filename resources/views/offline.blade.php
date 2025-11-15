<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - {{ $settings->site_name ?? config('app.name', 'Tulip') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .offline-container {
            text-align: center;
            padding: 2rem;
            max-width: 500px;
        }

        .offline-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .offline-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .offline-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .offline-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .cached-pages {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .cached-pages h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .cached-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .cached-links a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cached-links a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Social Media Icons */
        .social-icons a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .social-icons a.whatsapp:hover {
            background: #25D366;
        }

        .social-icons a.facebook:hover {
            background: #1877F2;
        }

        .social-icons a.twitter:hover {
            background: #1DA1F2;
        }

        .social-icons a.instagram:hover {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .social-icons a.linkedin:hover {
            background: #0077B5;
        }

        .social-icons a.youtube:hover {
            background: #FF0000;
        }

        @media (max-width: 768px) {
            .offline-title {
                font-size: 2rem;
            }

            .offline-actions {

                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="offline-container">
        <div class="offline-icon">📡</div>
        <h1 class="offline-title">You are offline</h1>
        <p class="offline-message">
            It seems you've lost your internet connection. Don't worry! Some pages are available offline, and you can
            access the saved content.
        </p>

        <div class="offline-actions">
            <button class="btn btn-primary" onclick="window.location.reload()">
                🔄 Try again
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                🏠 Return to Home
            </a>
            <button class="btn btn-secondary" onclick="window.history.back()">
                ← Go Back
            </button>
        </div>

        <!-- Contact Section -->
        <div class="cached-pages" style="background: rgba(255, 255, 255, 0.15); margin-top: 2rem;">
            <h3>📞 Contact Us</h3>
            <div class="contact-grid"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
                @if ($phones && $phones->count() > 0)
                    @foreach ($phones as $phone)
                        <div
                            style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 10px; text-align: center;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                {{ $phone->name ?? 'Contact Us' }}</h4>
                            <div style="color: #fff; margin: 0.3rem 0;">
                                <a href="tel:{{ $phone->phone }}"
                                    style="color: #fff; text-decoration: none; font-weight: 600;">{{ $phone->phone }}</a>
                            </div>
                            @if ($phone->email)
                                <div style="color: #fff; margin: 0.3rem 0;">
                                    <a href="mailto:{{ $phone->email }}"
                                        style="color: #fff; text-decoration: none; font-weight: 600;">{{ $phone->email }}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div
                        style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 10px; text-align: center;">
                        <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.1rem;">📞 اتصل بنا</h4>
                        <div style="color: #fff; margin: 0.3rem 0;">
                            <a href="tel:+20-xxx-xxx-xxxx"
                                style="color: #fff; text-decoration: none; font-weight: 600;">+20-xxx-xxx-xxxx</a>
                        </div>
                    </div>
                @endif

                @if ($site_addresses && $site_addresses->count() > 0)
                    @foreach ($site_addresses as $address)
                        <div
                            style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 10px; text-align: center;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.1rem;">📍
                                {{ $address->title ?? 'العنوان' }}</h4>
                            <div style="color: #fff; margin: 0.3rem 0;">
                                {{ $address->address }}
                            </div>
                            @if ($address->email)
                                <div style="color: #fff; margin: 0.3rem 0;">
                                    <a href="mailto:{{ $address->email }}"
                                        style="color: #fff; text-decoration: none; font-weight: 600;">{{ $address->email }}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div
                        style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 10px; text-align: center;">
                        <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.1rem;">📍 العنوان</h4>
                        <div style="color: #fff; margin: 0.3rem 0;">
                            القاهرة، مصر
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="social-icons"
            style="display: flex; justify-content: center; gap: 1rem; margin-top: 1.5rem; flex-wrap: wrap;">
            @foreach ($socialMediaLinks as $platform => $link)
                @if ($link && $link != '#')
                    <a href="{{ $link }}" target="_blank" class="{{ $platform }}">
                        <i class="fab fa-{{ $platform }}"></i>
                    </a>
                @endif
            @endforeach

            <!-- WhatsApp Icon -->
            @if (isset($settings->whatsapp_number) && $settings->whatsapp_number)
                <a href="https://wa.me/{{ $settings->whatsapp_number }}" target="_blank" class="whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            @endif
        </div>
        <div class="cached-pages" style="margin-top: 2rem;">
            <h3>📱 All pages available offline</h3>
            <div class="cached-links">
                <a href="{{ url('/') }}">🏠 Home Page</a>
                <a href="{{ url('/about-us') }}">ℹ️ About Us</a>
                <a href="{{ url('/services') }}">🛠️ Services</a>
                <a href="{{ url('/contact-us') }}">📞 Contact Us</a>
                <a href="{{ url('/amp/home') }}">⚡ Home Page AMP</a>
            </div>
        </div>

        <div
            style="margin-top: 2rem; padding: 1rem; background: rgba(40, 167, 69, 0.2); border-radius: 10px; color: #fff; border-left: 4px solid #28a745;">
            <p><strong>💡 Tip:</strong>
            </p>
        </div>

        <div style="margin-top: 2rem; opacity: 0.7; font-size: 0.9rem;">
            <p>🔔 Enable notifications to get updates when you're back online!</p>
        </div>
    </div>

    <script>
        // Check if we're back online
        window.addEventListener('online', function() {
            // Show a message that we're back online
            const message = document.createElement('div');
            message.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 1rem 2rem;
                border-radius: 5px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                animation: slideIn 0.3s ease;
            `;
            message.innerHTML = '🌐 You are back online again!';
            document.body.appendChild(message);

            // Remove the message after 3 seconds
            setTimeout(() => {
                message.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (document.body.contains(message)) {
                        document.body.removeChild(message);
                    }
                }, 300);
            }, 3000);
        });

        // Check if we're offline
        window.addEventListener('offline', function() {
            console.log('📡 You are now offline');
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            setTimeout(() => {
                const notificationBtn = document.createElement('button');
                notificationBtn.className = 'btn btn-secondary';
                notificationBtn.style.marginTop = '1rem';
                notificationBtn.innerHTML = '🔔 Enable Notifications';
                notificationBtn.onclick = () => {
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            notificationBtn.innerHTML = '✅ Notifications Enabled';
                            notificationBtn.disabled = true;
                        }
                    });
                };
                document.querySelector('.offline-actions').appendChild(notificationBtn);
            }, 2000);
        }
    </script>
</body>

</html>

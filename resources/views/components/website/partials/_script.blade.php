    <!-- Jquery -->
    <script src="{{ Path::js('jquery.js') }}"></script>
    <script src="{{ Path::js('popper.min.js') }}" defer></script>
    <script src="{{ Path::js('gallery.js') }}" defer></script>
    <script src="{{ Path::js('appear.js') }}" defer></script>
    <script src="{{ Path::js('mixitup.js') }}" defer></script>
    <script src="{{ Path::js('script.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script>
        // Dark Mode Toggle
        function enableDarkMode() {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
        }

        function disableDarkMode() {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
        }

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            enableDarkMode();
        } else {
            enableDarkMode(); // Force dark mode
        }

        document.addEventListener('DOMContentLoaded', function () {
            var swiper = new Swiper('.main-swiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                speed: 1200,
                loopedSlides: 1,
                on: {
                    slideChange: function () {
                        // إعادة تشغيل الانيميشن عند تغيير الشريحة
                        const title = document.querySelector('.slide-title-animated');
                        const subtitle = document.querySelector('.slide-subtitle-animated');

                        if (title && subtitle) {
                            title.style.animation = 'none';
                            subtitle.style.animation = 'none';

                            setTimeout(() => {
                                title.style.animation = 'slideInFromTop 1.5s ease-out 0.5s forwards';
                                subtitle.style.animation = 'slideInFromBottom 1.5s ease-out 1s forwards';
                            }, 100);
                        }
                    }
                }
            });

            // إضافة تأثير hover للصورة
            const slideImage = document.querySelector('.swiper-slide img');
            if (slideImage) {
                slideImage.addEventListener('mouseenter', function () {
                    this.style.animationPlayState = 'paused';
                });

                slideImage.addEventListener('mouseleave', function () {
                    this.style.animationPlayState = 'running';
                });
            }
        });
    </script>

    <!-- أنيميشن بسيط للعنوان والسب تايتل -->


    <script>
        // Lazy load YouTube embed
        function loadYT(videoId) {
            var iframe = document.createElement('iframe');
            iframe.width = '100%';
            iframe.height = '315';
            iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            iframe.title = 'YouTube video player';
            iframe.frameBorder = '0';
            iframe.allowFullscreen = true;
            iframe.style.borderRadius = '8px';
            var container = document.getElementById('yt-lazy-container');
            container.innerHTML = '';
            container.appendChild(iframe);
        }
        // زر التشغيل على الصورة
        var ytContainer = document.getElementById('yt-lazy-container');
        ytContainer.addEventListener('click', function () {
            var activeBtn = document.querySelector('.testimonial-tab.active');
            var vid = activeBtn.getAttribute('data-video');
            loadYT(vid);
        });
        // تبديل الفيديو عند تغيير التبويب
        var tabs = document.querySelectorAll('.testimonial-tab');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.background = '#fff';
                    t.style.color = '#111';
                });
                tab.classList.add('active');
                tab.style.background = '#4b92fe';
                tab.style.color = '#fff';
                // تغيير صورة المعاينة
                var vid = tab.getAttribute('data-video');
                var thumb = document.getElementById('yt-thumb');
                if (thumb) {
                    thumb.src = 'https://img.youtube.com/vi/' + vid + '/hqdefault.jpg';
                }
                // إعادة زر التشغيل
                var container = document.getElementById('yt-lazy-container');
                container.innerHTML = '<img id="yt-thumb" src="https://img.youtube.com/vi/' + vid + '/hqdefault.jpg" alt="YouTube Thumbnail" style="width:100%;height:100%;object-fit:cover;display:block;"><span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(0,0,0,0.5);border-radius:50%;padding:18px;"><svg width="36" height="36" viewBox="0 0 36 36" fill="#fff" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" r="18" fill="#4b92fe"/><polygon points="14,11 26,18 14,25" fill="#fff"/></svg></span>';
            });
        });
    </script>

    <!-- Before & After Slider Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var beforeAfterSwiper = new Swiper('.before-after-swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                slidesPerView: 1,
                spaceBetween: 30,
                breakpoints: {
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 1,
                        spaceBetween: 30
                    }
                },
                speed: 800,
                effect: 'slide'
            });
        });
    </script>
    <!-- Lazy load testimonials section -->

<script>'undefined' === typeof _trfq || (window._trfq = []); 'undefined' === typeof _trfd && (window._trfd = []), _trfd.push({ 'tccl.baseHost': 'secureserver.net' }, { 'ap': 'cpsh-oh' }, { 'server': 'sxb1plzcpnl508948' }, { 'dcenter': 'sxb1' }, { 'cp_id': '10268376' }, { 'cp_cl': '8' }) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script>
<script src='https://img1.wsimg.com/traffic-assets/js/tccl.min.js'></script>    
<!--#################### Service Worker is registered in _head.blade.php ####################-->

<script>
    let recaptchaLoaded = false;

    function loadRecaptcha() {
        if (recaptchaLoaded) return;
        recaptchaLoaded = true;

        const script = document.createElement('script');
        script.src = "https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoadCallback&render=explicit";
        script.async = true;
        script.defer = true;
        document.body.appendChild(script);
    }

    function onRecaptchaLoadCallback() {
        grecaptcha.render(document.querySelector('.g-recaptcha'), {
            'sitekey': "{{ config('captcha.sitekey') }}"
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".contact-form");
        if (form) {
            form.addEventListener("focusin", loadRecaptcha, {
                once: true
            });
        }
    });
</script>

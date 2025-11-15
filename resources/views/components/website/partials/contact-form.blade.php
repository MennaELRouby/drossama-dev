@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{ route('website.saveConatct') }}">
    @csrf
    <div class="row">
        <input type="hidden" name="recaptcha_token" id="recaptcha_token">
        <div class="form-group col-lg-12 col-md-12">
            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('website.name') }}" required="">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            <input type="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('website.phone') }}" required="">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('website.email') }}">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            <input type="text" name="message" value="{{ old('message') }}" placeholder="{{ __('website.message') }}">
        </div>
        @if (config('captcha.sitekey') && config('captcha.sitekey') !== 'Key')
            <div class="form-group col-lg-12 col-md-12">
                <div class="g-recaptcha" data-sitekey="{{ config('captcha.sitekey') }}"></div>
            </div>
        @endif
        <div class="form-group col-lg-12 col-md-12">
            <button type="submit" class="theme-btn btn-style-one bg-dark"><span class="btn-title">{{ __('website.send') }} <i
                        class="fa fa-angle-double-right"></i></span></button>
        </div>
    </div>
</form>
<!-- <======================= EndContactForm =========================> -->
@if (config('captcha.sitekey') && config('captcha.sitekey') !== 'Key')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.sitekey') }}"></script>

    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('captcha.sitekey') }}', {
                action: 'contact'
            }).then(function(token) {
                document.getElementById('recaptcha_token').value = token;
            }).catch(function(error) {
                console.warn('reCAPTCHA error:', error);
            });
        });
    </script>
@else
    <script>
        console.warn('reCAPTCHA is not configured properly. Please set NOCAPTCHA_SITEKEY in your .env file');
    </script>
@endif

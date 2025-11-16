 @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
 <form id="contact_form" name="contact_form" class="" action="{{ route('website.saveContact') }}" method="POST">
     @csrf
     {{-- <input type="hidden" name="_token" value="FtMWS0ink9X7SIeCmhFWc8JMLYzv92lavdMKxsjF" autocomplete="off"> --}}
     <div class="row">
         {{-- <input type="hidden" name="recaptcha_token" id="recaptcha_token"> --}}
         <div class="col-sm-6">
             <div class="mb-3">
                 <input name="name" class="form-control" type="text" value="{{ old('name') }}"
                     placeholder="{{ __('website.name') }}" required>
             </div>
         </div>
         <div class="col-sm-6">
             <div class="mb-3">
                 <input name="email" class="form-control" type="email" value="{{ old('email') }}"
                     placeholder="{{ __('website.email') }}" required>
             </div>
         </div>
     </div>
     <div class="row">


         <div class="col-sm-12">
             <div class="mb-3">
                 <input name="phone" class="form-control" type="text" value="{{ old('phone') }}"
                     placeholder="{{ __('website.phone') }}" required>
             </div>
         </div>
     </div>
     <div class="mb-3">
         <textarea name="message" class="form-control required" rows="7" placeholder="{{ __('website.message') }}">{{ old('message') }}</textarea>
     </div>
     {{-- @if (config('captcha.sitekey') && config('captcha.sitekey') !== 'Key')
         <div class="form-group col-lg-12 col-md-12">
             <div class="g-recaptcha" data-sitekey="{{ config('captcha.sitekey') }}"></div>
         </div>
     @endif --}}
     <div class="mb-5">
         <input name="form_botcheck" class="form-control" type="hidden" value="" />
         <button type="submit" class="theme-btn btn-style-one" data-loading-text="Please wait..."><span
                 class="btn-title">{{ __('website.send') }}</span></button>
     </div>
 </form>



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
 <!-- Contact Form Validation-->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="dz-form style-1 dzForm radius-no" action="{{ LaravelLocalization::localizeUrl('save/contact-us') }}"
    method="POST">
    <input type="hidden" class="form-control" name="dzToDo" value="Contact">
    <div class="dzFormMsg"></div>
    <div class="row sp10">
        <div class="col-sm-6 m-b20">
            <div class="input-group">
                <input type="text" class="form-control" name="name" placeholder="{{ trans('home.name') }}"
                    required>
            </div>
        </div>
        <div class="col-sm-6 m-b20">
            <div class="input-group">
                <input type="number" class="form-control" name="phone" placeholder="{{ trans('home.phone') }}"
                    required>
            </div>
        </div>
        <div class="col-sm-12 col-12 m-b20">
            <div class="input-group">
                <input type="text" class="form-control" name="email" placeholder="{{ trans('home.email') }}"
                    required>
            </div>
        </div>
        <div class="col-sm-12 m-b20">
            <div class="input-group">
                <textarea name="message" class="form-control" placeholder="{{ trans('home.message') }}"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            @if (config('services.recaptcha.sitekey') && config('services.recaptcha.sitekey') !== 'Key')
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}">
                </div>
            @else
                <div class="alert alert-warning">
                    <small>reCAPTCHA is not configured properly. Please contact administrator.</small>
                </div>
            @endif
        </div>
        <div class="col-sm-12">
            <button name="submit" type="submit" value="submit" class="btn btn-primary"> {{ trans('home.send') }} <i
                    class="m-l10 fas fa-caret-right"></i></button>
        </div>
    </div>
</form>

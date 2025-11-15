<form action="{{ route('website.saveConatct') }}" method="POST" class="contact-form">
    @csrf
    <input type="hidden" name="service_id" value="{{ $service->id ?? null }}">
    <input type="hidden" name="product_id" value="{{ $product->id ?? null }}">

    <div class="col-12">
        <div class="comments-form-wrapper style3 wow fadeInUp" data-wow-delay=".6s">
            <div class="comments-form position-relative mt-0">
                <h4 class="title">{{ __('website.Get in touch with us') }}</h4>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('website.name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('website.email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('website.phone') }}" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-groups email-group">
                            <textarea name="message" placeholder="{{ __('website.message') }}">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        {{-- عنصر reCAPTCHA بدون تحميل تلقائي --}}
                        <div class="g-recaptcha"></div>
                        @error('g-recaptcha-response')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="arrow-wrap mt-4">
                    <button type="submit">
                        <span class="arrow-long d-flex align-items-center justify-content-center rounded-pill">
                            {{ __('website.Send message') }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

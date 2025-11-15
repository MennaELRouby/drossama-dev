<div class="content-area" dir="rtl">
    <div class="btns">
        @foreach ($phones as $key => $phone)
                @if ($phone->type == 'phone')
                    <div class="Call-btn" style="text-align: center;">
                        <a class="fixed-phone" href="tel:{{ $phone->code }}{{ $phone->phone }}" target="_blank"
                            rel="noopener">{{ __('website.call') }}</a>
                    </div>
                @elseif($phone->type == 'whatsapp')
                    <div class="Whatsapp-btn" style="text-align: center;">
                        <a class="fixed-whatsapp" href="https://wa.me/{{ $phone->code }}{{ $phone->phone }}"
                            target="_blank" rel="noopener">{{ __('website.whatsapp') }}</a>
                    </div>
                @endif
        @endforeach
    </div>
</div>

<style>
    .content-area .btns {
        display: flex;
        justify-content: space-around;
        margin: 25px;
    }

    .content-area .btns .Whatsapp-btn,
    .content-area .btns .Call-btn {
        padding: 10px 20px;
        background-color: #2a3f66;
        border-radius: 20px;
    }

    .content-area .btns i {
        margin: 0 5px;
    }

    .content-area .btns .Whatsapp-btn a,
    .content-area .btns .Call-btn a {
        color: #fff;
    }

    .contact-form {
        padding: 20px
    }
</style>

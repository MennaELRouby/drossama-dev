<x-dashboard.layout :title="__('dashboard.edit_setting')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit_setting')" :label_url="route('dashboard.home')" :label="__('dashboard.home')" />
    <!-- End Page Header -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Email Settings -->
                <div class="card custom-card mb-4">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-envelope"></i>
                            {{ __('dashboard.email_settings') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_email">
                                        <i class="fas fa-at"></i>
                                        {{ __('dashboard.site_email') }}
                                    </label>
                                    <input type="email" class="form-control" name="site_email"
                                        value="{{ $settings['site_email'] }}" placeholder="info@example.com">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notification_emails">
                                        <i class="fas fa-envelope-open-text"></i>
                                        {{ __('dashboard.notification_emails') }}
                                    </label>
                                    <textarea class="form-control" name="notification_emails" rows="3"
                                        placeholder="{{ __('dashboard.notification_emails_placeholder') }}">{{ $settings['notification_emails'] ?? '' }}</textarea>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        {{ __('dashboard.notification_emails_help') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card custom-card mb-4">
                    <div class="card-header bg-info">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-phone"></i>
                            {{ __('dashboard.contact_information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                        {{ __('dashboard.site_whatspp') }}
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="country_code" class="form-control">
                                                <option value="+20"
                                                    {{ ($settings['country_code'] ?? '') == '+20' ? 'selected' : '' }}>
                                                    🇪🇬
                                                    +20</option>
                                                <option value="+966"
                                                    {{ ($settings['country_code'] ?? '') == '+966' ? 'selected' : '' }}>
                                                    🇸🇦
                                                    +966</option>
                                                <option value="+971"
                                                    {{ ($settings['country_code'] ?? '') == '+971' ? 'selected' : '' }}>
                                                    🇦🇪
                                                    +971</option>
                                                <option value="+1"
                                                    {{ ($settings['country_code'] ?? '') == '+1' ? 'selected' : '' }}>
                                                    🇺🇸
                                                    +1</option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="site_whatsapp"
                                            value="{{ $settings['site_whatsapp'] ?? '' }}" placeholder="1234567890">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">
                                        <i class="fas fa-phone-alt"></i>
                                        {{ __('dashboard.phone') }}
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="country_code" class="form-control">
                                                <option value="+20"
                                                    {{ ($settings['country_code'] ?? '') == '+20' ? 'selected' : '' }}>
                                                    🇪🇬
                                                    +20</option>
                                                <option value="+966"
                                                    {{ ($settings['country_code'] ?? '') == '+966' ? 'selected' : '' }}>
                                                    🇸🇦
                                                    +966</option>
                                                <option value="+971"
                                                    {{ ($settings['country_code'] ?? '') == '+971' ? 'selected' : '' }}>
                                                    🇦🇪
                                                    +971</option>
                                                <option value="+1"
                                                    {{ ($settings['country_code'] ?? '') == '+1' ? 'selected' : '' }}>
                                                    🇺🇸
                                                    +1</option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="phone"
                                            value="{{ $settings['phone'] ?? '' }}" placeholder="1234567890">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card custom-card mb-4">
                    <div class="card-header bg-success">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-share-alt"></i>
                            {{ __('dashboard.social_media') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_facebook">
                                        <i class="fab fa-facebook"></i>
                                        {{ __('dashboard.site_facebook') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_facebook"
                                        value="{{ $settings['site_facebook'] }}"
                                        placeholder="https://facebook.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_twitter">
                                        <i class="fab fa-twitter"></i>
                                        {{ __('dashboard.site_twitter') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_twitter"
                                        value="{{ $settings['site_twitter'] }}" placeholder="https://twitter.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_instagram">
                                        <i class="fab fa-instagram"></i>
                                        {{ __('dashboard.site_instagram') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_instagram"
                                        value="{{ $settings['site_instagram'] }}"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_linkedin">
                                        <i class="fab fa-linkedin"></i>
                                        {{ __('dashboard.site_linkedin') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_linkedin"
                                        value="{{ $settings['site_linkedin'] }}"
                                        placeholder="https://linkedin.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_youtube">
                                        <i class="fab fa-youtube"></i>
                                        {{ __('dashboard.site_youtube') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_youtube"
                                        value="{{ $settings['site_youtube'] }}"
                                        placeholder="https://youtube.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_snapchat">
                                        <i class="fab fa-snapchat"></i>
                                        {{ __('dashboard.site_snapchat') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_snapchat"
                                        value="{{ $settings['site_snapchat'] }}"
                                        placeholder="https://snapchat.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_tiktok">
                                        <i class="fab fa-tiktok"></i>
                                        {{ __('dashboard.site_tiktok') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_tiktok"
                                        value="{{ $settings['site_tiktok'] }}" placeholder="https://tiktok.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_pinterest">
                                        <i class="fab fa-pinterest"></i>
                                        {{ __('dashboard.site_pinterest') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_pinterest"
                                        value="{{ $settings['site_pinterest'] }}"
                                        placeholder="https://pinterest.com/...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_telegram">
                                        <i class="fab fa-telegram"></i>
                                        {{ __('dashboard.site_telegram') }}
                                    </label>
                                    <input type="url" class="form-control" name="site_telegram"
                                        value="{{ $settings['site_telegram'] }}" placeholder="https://t.me/...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics & Map -->
                <div class="card custom-card mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-chart-line"></i>
                            {{ __('dashboard.analytics_and_map') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_analytics_id">
                                        <i class="fas fa-chart-bar"></i>
                                        {{ __('dashboard.google_analytics_id') }}
                                    </label>
                                    <input type="text" class="form-control" name="google_analytics_id"
                                        value="{{ $settings['google_analytics_id'] ?? '' }}"
                                        placeholder="G-XXXXXXXXXX">
                                    <small class="form-text text-muted">
                                        {{ __('dashboard.google_analytics_id_help') }}
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_tag_manager_id">
                                        <i class="fas fa-tags"></i>
                                        {{ __('dashboard.google_tag_manager_id') }}
                                    </label>
                                    <input type="text" class="form-control" name="google_tag_manager_id"
                                        value="{{ $settings['google_tag_manager_id'] ?? '' }}"
                                        placeholder="GTM-PZSPLT25">
                                    <small class="form-text text-muted">
                                        {{ __('dashboard.google_tag_manager_id_help') }}
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_map">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ __('dashboard.site_map') }}
                                    </label>
                                    <textarea class="form-control" rows="3" name="site_map" placeholder="Paste Google Maps iframe code here...">{{ $settings['site_map'] }}</textarea>
                                </div>
                            </div>

                            @if (!empty($settings['site_map']))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('dashboard.map_preview') }}</label>
                                        <div class="border rounded" style="overflow: hidden;">
                                            <iframe src="{{ $settings['site_map'] }}" width="100%" height="300"
                                                style="border:0;" allowfullscreen="" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div>
                                <button type="submit" class="btn btn-success btn-lg mb-2">
                                    <i class="fas fa-save"></i>
                                    {{ __('dashboard.update') }}
                                </button>
                                <a href="{{ route('dashboard.settings.show') }}"
                                    class="btn btn-secondary btn-lg mb-2">
                                    <i class="fas fa-times"></i>
                                    {{ __('dashboard.cancel') }}
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('dashboard.email-test.index') }}" class="btn btn-info btn-lg mb-2">
                                    <i class="fas fa-envelope-open-text"></i>
                                    {{ __('dashboard.test_email_system') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- End Row -->
</x-dashboard.layout>

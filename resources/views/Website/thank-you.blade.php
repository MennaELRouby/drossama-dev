<x-website.layout>
    <section class="thank-you-section bg-light-color py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="thank-you-card bg-white p-5 rounded shadow text-center">
                        <!-- Success Icon -->
                        <div class="success-icon mb-4">
                            <div class="check-circle mx-auto">
                                <i class="fas fa-check-circle text-primary" style="font-size: 80px;"></i>
                            </div>
                        </div>

                        <!-- Thank You Message -->
                        <h1 class="display-5 text-primary mb-3">{{ __('website.thank_you') }}!</h1>
                        <h4 class="text-muted mb-4">{{ __('website.message_received') }}</h4>

                        <div class="message-box p-4 bg-light rounded mb-4">
                            <p class="mb-0 lead">{{ __('website.thanks_message') }}</p>
                        </div>

                        <!-- Contact Info - Branches -->
                        <div class="contact-quick-info mb-4">
                            <p class="text-muted mb-3">{{ __('website.need_immediate_help') }}</p>

                            @php
                                $site_addresses = \App\Models\SiteAddress::where('status', 1)->orderBy('order')->get();
                            @endphp

                            @if ($site_addresses && $site_addresses->count() > 0)
                                <div class="row g-3">
                                    @foreach ($site_addresses as $address)
                                        <div class="col-md-6">
                                            <div class="branch-card p-3 border rounded h-100">
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="fas fa-map-marker-alt text-primary me-2 mt-1"></i>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $address->title }}</h6>
                                                        <small
                                                            class="text-muted d-block mb-2">{{ $address->address }}</small>
                                                    </div>
                                                </div>
                                                @if ($address->phone)
                                                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', $address->phone) }}"
                                                        class="btn btn-success btn-sm w-100" target="_blank">
                                                        <i class="fab fa-whatsapp me-1"></i>
                                                        {{ __('website.whatsapp') }}: {{ $address->phone }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    @if (isset($settings['site_whatsapp']))
                                        <a href="https://wa.me/{{ str_replace(['+', ' '], '', $settings['site_whatsapp']) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fab fa-whatsapp me-1"></i> {{ __('website.whatsapp') }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons mt-5">
                            <a href="{{ url('/') }}" class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-home me-2"></i>{{ __('website.back_to_home') }}
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('website.go_back') }}
                            </a>
                        </div>

                        <!-- Features -->
                        <div class="features-grid mt-5 pt-4 border-top">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="fas fa-clock text-primary mb-2" style="font-size: 30px;"></i>
                                        <h6>{{ __('website.quick_response') }}</h6>
                                        <small class="text-muted">{{ __('website.within_24_hours') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="fas fa-headset text-primary mb-2" style="font-size: 30px;"></i>
                                        <h6>{{ __('website.professional_support') }}</h6>
                                        <small class="text-muted">{{ __('website.expert_team') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="fas fa-shield-alt text-primary mb-2" style="font-size: 30px;"></i>
                                        <h6>{{ __('website.secure_data') }}</h6>
                                        <small class="text-muted">{{ __('website.privacy_protected') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .thank-you-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .thank-you-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .check-circle i {
            animation: scaleIn 0.5s ease-out 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .feature-item {
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .message-box {
            border-left: 4px solid #7FC3C2;
        }

        .branch-card {
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .branch-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #7FC3C2 !important;
        }

        .branch-card h6 {
            color: #164852;
            font-weight: 600;
        }

        .branch-card .btn-success {
            background-color: #25D366;
            border-color: #25D366;
        }

        .branch-card .btn-success:hover {
            background-color: #128C7E;
            border-color: #128C7E;
        }
    </style>
</x-website.layout>

<x-dashboard.layout :title="__('dashboard.test_email_system')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.test_email_system')" :label_url="route('dashboard.settings.show')" :label="__('dashboard.settings')" />
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-envelope-open-text"></i>
                        {{ __('dashboard.test_email_system') }}
                    </h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Email Configuration Info -->
                    <div class="alert alert-info">
                        <h5>
                            <i class="fas fa-info-circle"></i>
                            {{ __('dashboard.email_configuration') }}
                        </h5>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>{{ __('dashboard.mail_driver') }}:</strong> {{ config('mail.default') }}
                                </p>
                                <p><strong>{{ __('dashboard.mail_host') }}:</strong>
                                    {{ config('mail.mailers.smtp.host') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('dashboard.mail_port') }}:</strong>
                                    {{ config('mail.mailers.smtp.port') }}</p>
                                <p><strong>{{ __('dashboard.mail_from') }}:</strong>
                                    {{ config('mail.from.address') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Configured Emails -->
                    @if (count($emails) > 0)
                        <div class="alert alert-success">
                            <h5>
                                <i class="fas fa-users"></i>
                                {{ __('dashboard.configured_recipients') }} ({{ count($emails) }})
                            </h5>
                            <div class="mt-2">
                                @foreach ($emails as $email)
                                    <span class="badge badge-primary mr-1 mb-1"
                                        style="font-size: 14px; padding: 8px 12px;">
                                        <i class="fas fa-envelope"></i> {{ $email }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ __('dashboard.no_emails_configured') }}
                            <a href="{{ route('dashboard.settings.show') }}">{{ __('dashboard.configure_now') }}</a>
                        </div>
                    @endif

                    <!-- Test Email Form -->
                    <div class="card border-primary mt-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-paper-plane"></i>
                                {{ __('dashboard.send_test_email') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.email-test.send') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- Test Type -->
                                    <div class="form-group col-md-6">
                                        <label for="test_type">
                                            <i class="fas fa-list"></i>
                                            {{ __('dashboard.test_type') }}
                                        </label>
                                        <select name="test_type" id="test_type" class="form-control" required>
                                            <option value="notification">{{ __('dashboard.notification_email') }}
                                            </option>
                                            <option value="contact">{{ __('dashboard.contact_form_email') }}</option>
                                        </select>
                                        @error('test_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Recipient -->
                                    <div class="form-group col-md-6">
                                        <label for="recipient">
                                            <i class="fas fa-at"></i>
                                            {{ __('dashboard.recipient_email') }}
                                        </label>
                                        <select name="recipient" id="recipient" class="form-control" required>
                                            @if ($primaryEmail)
                                                <option value="{{ $primaryEmail }}">{{ $primaryEmail }}
                                                    ({{ __('dashboard.primary') }})</option>
                                            @endif
                                            @foreach ($emails as $email)
                                                @if ($email !== $primaryEmail)
                                                    <option value="{{ $email }}">{{ $email }}</option>
                                                @endif
                                            @endforeach
                                            <option value="custom">{{ __('dashboard.custom_email') }}</option>
                                        </select>
                                        @error('recipient')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Custom Email Input (Hidden by default) -->
                                    <div class="form-group col-md-12" id="customEmailDiv" style="display: none;">
                                        <label for="custom_recipient">
                                            <i class="fas fa-envelope"></i>
                                            {{ __('dashboard.enter_custom_email') }}
                                        </label>
                                        <input type="email" class="form-control" id="custom_recipient"
                                            placeholder="example@domain.com">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane"></i>
                                            {{ __('dashboard.send_test_email') }}
                                        </button>
                                        <a href="{{ route('dashboard.settings.show') }}"
                                            class="btn btn-secondary btn-lg">
                                            <i class="fas fa-arrow-left"></i>
                                            {{ __('dashboard.back_to_settings') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Help Section -->
                    <div class="alert alert-light border mt-4">
                        <h5>
                            <i class="fas fa-question-circle"></i>
                            {{ __('dashboard.help') }}
                        </h5>
                        <ul class="mb-0">
                            <li>{{ __('dashboard.test_email_help_1') }}</li>
                            <li>{{ __('dashboard.test_email_help_2') }}</li>
                            <li>{{ __('dashboard.test_email_help_3') }}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    @push('scripts')
        <script>
            document.getElementById('recipient').addEventListener('change', function() {
                const customDiv = document.getElementById('customEmailDiv');
                const customInput = document.getElementById('custom_recipient');
                const recipientSelect = document.getElementById('recipient');

                if (this.value === 'custom') {
                    customDiv.style.display = 'block';
                    customInput.required = true;

                    // Update the select value with custom input
                    customInput.addEventListener('input', function() {
                        // Create or update custom option
                        let customOption = recipientSelect.querySelector('option[value="' + this.value + '"]');
                        if (!customOption && this.value) {
                            customOption = document.createElement('option');
                            customOption.value = this.value;
                            customOption.selected = true;
                            recipientSelect.appendChild(customOption);
                        }
                        if (customOption && this.value) {
                            recipientSelect.value = this.value;
                        }
                    });
                } else {
                    customDiv.style.display = 'none';
                    customInput.required = false;
                }
            });
        </script>
    @endpush

</x-dashboard.layout>

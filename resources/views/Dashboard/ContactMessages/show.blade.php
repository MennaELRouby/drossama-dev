<x-dashboard.layout :title="__('dashboard.messages')">
    <div class="container-fluid">


        <!-- Page Header -->
        <x-dashboard.partials.page-header :header="__('dashboard.message_from') . ' ' . $message->name" :label_url="route('dashboard.contact_messages.index')" :label="__('dashboard.messages')" />
        <!-- End Page Header -->

        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 mb-0">{{ $message->name }}</h5>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">📧 {{ __('dashboard.email') }}</h6>
                                        <p class="mb-0">{{ $message->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">📱 {{ __('dashboard.phone') }}</h6>
                                        <p class="mb-0">{{ $message->phone }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($message->company)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">🏢 {{ __('dashboard.company') }}</h6>
                                            <p class="mb-0">{{ $message->company }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($message->branch)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">📍 {{ __('website.branch') }}</h6>
                                            <p class="mb-0">{{ $message->branch }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($message->date)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">📅 {{ __('website.appointment_date') }}</h6>
                                            <p class="mb-0">{{ $message->date }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($message->time)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">🕐 {{ __('website.appointment_time') }}</h6>
                                            <p class="mb-0">{{ $message->time }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($message->service)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">🛠️ {{ __('dashboard.service') }}</h6>
                                            <p class="mb-0">{{ $message->service->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($message->product)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">📦 {{ __('dashboard.product') }}</h6>
                                            <p class="mb-0">{{ $message->product->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">💬 {{ __('dashboard.message') }}</h6>
                                        <p class="mb-0">{!! nl2br(e($message->message)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- end Col -->

        </div>
    </div>
</x-dashboard.layout>

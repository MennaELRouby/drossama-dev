<x-dashboard.layout title="{{ __('dashboard.dashboard') }}">
    <div class="row">
        @foreach ($countModels as $key => $count)
            @can("{$key}.view")
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('dashboard.total_' . $key) }}</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="{{ $count }}">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart{{ $loop->index }}" class="apex-charts mb-2"
                                        data-colors='["#5156be"]'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endforeach
    </div>

</x-dashboard.layout>

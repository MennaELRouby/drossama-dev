<x-dashboard.layout :title="__('dashboard.plans')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.plans')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.plans') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons createUrl="{{ route('dashboard.plans.create') }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.name_en') }}</th>
                                    <th>{{ __('dashboard.name_ar') }}</th>
                                    <th>{{ __('dashboard.image') }}</th>
                                    <th>{{ __('dashboard.parent_hosting') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr id="{{ $plan->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $plan->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.plans.edit', $plan->id) }}">{{ $plan->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.plans.edit', $plan->id) }}">{{ $plan->name_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.plans.edit', $plan->id) }}">{{ $plan->name_ar }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.plans.edit', $plan->id) }}">
                                                <img src="{{ $plan->image_path }}" width="70">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.plans.edit', $plan->id) }}">
                                                {{ $plan->hosting?->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.plans.edit', $plan->id) }}" class="status">
                                                @if ($plan->status == 1)
                                                    {{ __('dashboard.yes') }}
                                                @else
                                                    {{ __('dashboard.no') }}
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end cardaa -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</x-dashboard.layout>

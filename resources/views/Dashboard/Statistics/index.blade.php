<x-dashboard.layout :title="__('dashboard.statistics')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.statistics')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.statistics') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">

                            <x-dashboard.partials.action-buttons
                                createUrl="{{ route('dashboard.statistics.create') }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.title_en') }}</th>
                                    <th>{{ __('dashboard.title_ar') }}</th>
                                    <th>{{ __('dashboard.value') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($statistics as $slider)
                                    <tr id="{{ $slider->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $slider->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.statistics.edit', $slider->id) }}">{{ $slider->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.statistics.edit', $slider->id) }}">{{ $slider->title_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.statistics.edit', $slider->id) }}">{{ $slider->title_ar }}</a>
                                        </td>

                                        <td><a
                                                href="{{ route('dashboard.statistics.edit', $slider->id) }}">{{ $slider->value }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.statistics.edit', $slider->id) }}"
                                                class="status">
                                                @if ($slider->status == 1)
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

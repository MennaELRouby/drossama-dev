<x-dashboard.layout :title="__('dashboard.parteners')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.parteners')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.parteners') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons createUrl="{{ route('dashboard.parteners.create') }}" />
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
                                    <th>{{ __('dashboard.logo') }}</th>
                                    <th>{{ __('dashboard.products') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($parteners as $partener)
                                    <tr id="{{ $partener->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $partener->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.parteners.edit', $partener->id) }}">{{ $partener->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.parteners.edit', $partener->id) }}">{{ $partener->name_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.parteners.edit', $partener->id) }}">{{ $partener->name_ar }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.parteners.edit', $partener->id) }}">
                                                <img src="{{ $partener->logo_path }}" width="70">
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.parteners.edit', $partener->id) }}">
                                                @if ($partener->products->count() > 0)
                                                    {{ $partener->products->pluck('name')->implode(', ') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.parteners.edit', $partener->id) }}"
                                                class="status">
                                                @if ($partener->status == 1)
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
    @section('script')
        <x-dashboard.partials.delete-btn />
        <script>
            $(function() {
                $('#checkAll').on('change', function() {
                    $('.check-inputs').prop('checked', this.checked);
                });
            });
        </script>
    @endsection
</x-dashboard.layout>

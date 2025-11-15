<x-dashboard.layout :title="__('dashboard.faqs')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.faqs')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.faqs') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons createUrl="{{ route('dashboard.faqs.create') }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.question') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr id="{{ $faq->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $faq->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.faqs.edit', $faq->id) }}">{{ $faq->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.faqs.edit', $faq->id) }}">{{ $faq->question }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.faqs.edit', $faq->id) }}">{{ $faq->type }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.faqs.edit', $faq->id) }}" class="status">
                                                @if ($faq->status == 1)
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

    @push('scripts')
        <x-dashboard.partials.datatable />
        <script>
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('#datatable-buttons')) {
                    $('#datatable-buttons').DataTable({
                        responsive: true,
                        autoWidth: false,
                        pageLength: 25,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                        }
                    });
                }

                $('#checkAll').on('click', function() {
                    $('.check-inputs').prop('checked', this.checked);
                });

                $(document).on('click', '.check-inputs', function() {
                    var total = $('.check-inputs').length;
                    var checked = $('.check-inputs:checked').length;
                    $('#checkAll').prop('checked', total === checked);
                });
            });
        </script>
        <x-dashboard.partials.delete-btn />
    @endpush
</x-dashboard.layout>

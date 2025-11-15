<x-dashboard.layout :title="__('dashboard.authors')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.authors')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.authors') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons createUrl="{{ route('dashboard.authors.create') }}" />
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
                                    <th>{{ __('dashboard.status') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($authors as $author)
                                    <tr id="{{ $author->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $author->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.authors.edit', $author->id) }}">{{ $author->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.authors.edit', $author->id) }}">{{ $author->name_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.authors.edit', $author->id) }}">{{ $author->name_ar }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.authors.edit', $author->id) }}">
                                                <img src="{{ $author->image_path }}" width="70">
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.authors.edit', $author->id) }}"
                                                class="status">
                                                @if ($author->status == 1)
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

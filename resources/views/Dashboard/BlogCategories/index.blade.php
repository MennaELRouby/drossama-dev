<x-dashboard.layout :title="__('dashboard.blog_categories')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.blog_categories')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.blog_categories') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <x-dashboard.partials.action-buttons
                                createUrl="{{ route('dashboard.blog_categories.create') }}" />
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
                                @foreach ($categories as $category)
                                    <tr id="{{ $category->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $category->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.blog_categories.edit', $category->id) }}">{{ $category->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.blog_categories.edit', $category->id) }}">{{ $category->name_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.blog_categories.edit', $category->id) }}">{{ $category->name_ar }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.blog_categories.edit', $category->id) }}">
                                                <img src="{{ $category->image_path }}" width="70">
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.blog_categories.edit', $category->id) }}"
                                                class="status">
                                                @if ($category->status == 1)
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

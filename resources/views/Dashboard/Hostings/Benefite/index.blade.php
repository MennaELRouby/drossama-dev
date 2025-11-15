<x-dashboard.layout :title="$hosting->name . ' ' . __('dashboard.benefits')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="$hosting->name . ' ' . __('dashboard.benefits')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.benefits') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <div class="btn btn-list">
                                <a href="{{ route('dashboard.hostings.benefits.create', $hosting->id) }}"><button
                                        class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i>
                                        {{ __('dashboard.add') }}</button></a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>

                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.title_en') }}</th>
                                    <th>{{ __('dashboard.title_ar') }}</th>
                                    <th>{{ __('dashboard.image') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.delete') }}</th>

                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($hosting->benefits as $benefit)
                                    <tr id="{{ $benefit->id }}">

                                        <td><a
                                                href="{{ route('dashboard.hostings.benefits.edit', [$hosting->id, $benefit->id]) }}">{{ $benefit->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.hostings.benefits.edit', [$hosting->id, $benefit->id]) }}">{{ $benefit->title_en }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.hostings.benefits.edit', [$hosting->id, $benefit->id]) }}">{{ $benefit->title_ar }}</a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('dashboard.hostings.benefits.edit', [$hosting->id, $benefit->id]) }}">
                                                <img src="{{ $benefit->image_path }}" width="70">
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.hostings.benefits.edit', [$hosting->id, $benefit->id]) }}"
                                                class="status">
                                                @if ($benefit->status == 1)
                                                    {{ __('dashboard.yes') }}
                                                @else
                                                    {{ __('dashboard.no') }}
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('dashboard.hostings.benefits.destroy', [$hosting->id, $benefit->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete"
                                                    data-toggle="modal" data-target="#deleteModal"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
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

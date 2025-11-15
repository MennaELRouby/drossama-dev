<x-dashboard.layout :title="$hosting->name . ' ' . __('dashboard.faqs')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="$hosting->name . ' ' . __('dashboard.faqs')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.faqs') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">
                            <div class="btn btn-list">
                                <a href="{{ route('dashboard.hostings.faqs.create', $hosting->id) }}"><button
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
                                    <th>{{ __('dashboard.question') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.delete') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($hosting->faqs as $faq)
                                    <tr id="{{ $faq->id }}">

                                        <td><a
                                                href="{{ route('dashboard.hostings.faqs.edit', [$hosting->id, $faq->id]) }}">{{ $faq->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.hostings.faqs.edit', [$hosting->id, $faq->id]) }}">{{ $faq->question }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('dashboard.hostings.faqs.edit', [$hosting->id, $faq->id]) }}"
                                                class="status">
                                                @if ($faq->status == 1)
                                                    {{ __('dashboard.yes') }}
                                                @else
                                                    {{ __('dashboard.no') }}
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('dashboard.hostings.faqs.destroy', [$hosting->id, $faq->id]) }}"
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

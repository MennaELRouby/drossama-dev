<x-dashboard.layout :title="__('dashboard.messages')">
    <div class="container-fluid">

        <!-- Page Header -->

        <x-dashboard.partials.page-header :header="__('dashboard.messages')" />

        <!-- End Page Header -->

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title pt-3">{{ __('dashboard.messages') }}</h4>

                        <div class="page-title-right d-flex justify-content-end">

                            <a id="btn_delete"><button class="btn ripple btn-danger"><i class="fas fa-trash"></i>
                                    {{ __('dashboard.delete') }}</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" /></th>
                                    <th>{{ __('dashboard.id') }}</th>
                                    <th>{{ __('dashboard.name') }}</th>
                                    <th>{{ __('dashboard.email') }}</th>
                                    <th>{{ __('dashboard.seen') }}</th>

                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($messages as $message)
                                    <tr id="{{ $message->id }}">
                                        <td><input type="checkbox" name="checkbox" class="form-check-input check-inputs"
                                                value="{{ $message->id }}" /></td>
                                        <td><a
                                                href="{{ route('dashboard.contact_messages.show', $message->id) }}">{{ $message->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.contact_messages.show', $message->id) }}">{{ $message->name }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('dashboard.contact_messages.show', $message->id) }}">{{ $message->email }}</a>
                                        </td>
                                        <td class="badge badge-soft-{{ $message->seen ? 'success' : 'warning' }}">
                                            {{ $message->seen ? __('dashboard.yes') : __('dashboard.no') }}</td>
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

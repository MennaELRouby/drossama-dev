<!-- Table -->
<div class="row">
    <div class="col-12">
        <div class="enhanced-page-header">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title pt-3">{{ __('dashboard.attribute_values') }}</h4>


                <div class="btn btn-list">
                    <a href="{{ route('dashboard.attributes.values.create', [$attribute->id]) }}"><button
                            class="btn ripple btn-primary"><i class="fas fa-plus-circle"></i>
                            {{ __('dashboard.add_attribute_values') }}</button></a>

                </div>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>{{ __('dashboard.id') }}</th>
                            <th>{{ __('dashboard.value_en') }}</th>
                            <th>{{ __('dashboard.value_ar') }}</th>
                            <th>{{ __('dashboard.status') }}</th>
                            <th>{{ __('dashboard.actions') }}</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($attribute->values as $value)
                            <tr id="row-{{ $value->id }}">
                                <td><input type="checkbox" name="checkbox" class="tableChecked"
                                        value="{{ $value->id }}" />
                                </td>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->value_en }}</td>
                                <td>{{ $value->value_ar }}</td>
                                <td>
                                    @if ($value->status == 1)
                                        {{ __('dashboard.yes') }}
                                    @else
                                        {{ __('dashboard.no') }}
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit Modal Button -->
                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $value->id }}">
                                        {{ __('dashboard.edit') }}
                                    </button>
                                    <form
                                        action="{{ route('dashboard.attributes.values.destroy', [$attribute->id, $value->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger waves-effect waves-light">{{ __('dashboard.delete') }}</button>
                                    </form>

                                </td>
                            </tr>


                            <!-- Include the Edit Modal -->
                            @include('Dashboard.Attribute-values.edit-model', ['value' => $value])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end cardaa -->
    </div> <!-- end col -->
</div>
<!-- end row -->

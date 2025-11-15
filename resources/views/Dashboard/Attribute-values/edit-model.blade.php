<!-- Edit Modal for this Record -->
<div class="modal fade" id="editModal-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Value') }} - {{ $value->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('dashboard.attributes.values.update',[$attribute->id,$value->id]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>{{ __('dashboard.value_en') }}</label>
                            <input class="form-control" name="value_en" type="text" value="{{ $value->value_en }}" placeholder="{{ __('dashboard.value_en') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('dashboard.value_ar') }}</label>
                            <input class="form-control" name="value_ar" type="text" value="{{ $value->value_ar }}" placeholder="{{ __('dashboard.value_ar') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('dashboard.price') }}</label>
                            <input class="form-control" name="price" type="text" value="{{ $value->price }}" placeholder="{{ __('dashboard.price') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <div class="d-flex flex-wrap gap-2">
                                <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }}</h5>
                                <input type="checkbox" id="switch-{{ $value->id }}" switch="none" name="status" value="1"
                                    {{ $value->status ? 'checked' : '' }} />
                                <label for="switch-{{ $value->id }}" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="btn-group" role="group" aria-label="Action buttons">
    <a href="{{ $createUrl }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus-circle me-1"></i>
        {{ __('dashboard.add') }}
    </a>
    <button id="btn_active" type="button" class="btn btn-dark btn-sm">
        <i class="fas fa-eye me-1"></i>
        {{ __('dashboard.publish/unpublish') }}
    </button>
    <button id="btn_delete" type="button" class="btn btn-danger btn-sm">
        <i class="fas fa-trash me-1"></i>
        {{ __('dashboard.delete') }}
    </button>
</div>

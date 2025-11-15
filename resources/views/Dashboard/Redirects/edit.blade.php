<x-dashboard.layout title="Edit Redirect #{{ $redirect->id }}">
    <div class="enhanced-page-header">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.redirects.update', $redirect) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Source</label>
                    <input name="source" class="form-control" value="{{ $redirect->source }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Target</label>
                    <input name="target" class="form-control" value="{{ $redirect->target }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Code</label>
                    <select name="status_code" class="form-select" required>
                        <option value="301" {{ $redirect->status_code == 301 ? 'selected' : '' }}>301 (Permanent)
                        </option>
                        <option value="302" {{ $redirect->status_code == 302 ? 'selected' : '' }}>302 (Temporary)
                        </option>
                        <option value="410" {{ $redirect->status_code == 410 ? 'selected' : '' }}>410 (Gone)</option>
                    </select>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="activeCheck"
                        {{ $redirect->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="activeCheck">Active</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <input name="notes" class="form-control" value="{{ $redirect->notes }}">
                </div>
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('dashboard.redirects.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</x-dashboard.layout>

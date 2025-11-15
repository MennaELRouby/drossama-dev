<x-dashboard.layout title="Add Redirect">
    <div class="enhanced-page-header">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.redirects.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Source (path or full URL)</label>
                    <input name="source" class="form-control" placeholder="/old-url or https://example.com/old" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Target (leave empty for 410)</label>
                    <input name="target" class="form-control" placeholder="https://example.com/new">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Code</label>
                    <select name="status_code" class="form-select" required>
                        <option value="301">301 (Permanent)</option>
                        <option value="302">302 (Temporary)</option>
                        <option value="410">410 (Gone)</option>
                    </select>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="activeCheck" checked>
                    <label class="form-check-label" for="activeCheck">Active</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes (optional)</label>
                    <input name="notes" class="form-control" placeholder="Reason or context">
                </div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('dashboard.redirects.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</x-dashboard.layout>

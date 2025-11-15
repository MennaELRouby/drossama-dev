<x-dashboard.layout title="Import Redirects">
    <div class="enhanced-page-header">
        <div class="card-body">
            <p>Upload a CSV file with the following columns: <code>source,target,status_code,is_active,notes</code></p>
            <p>
                Example:
                <pre class="bg-light p-2">source,target,status_code,is_active,notes
/en/blogs/old,https://example.com/en/blogs/new,301,1,
/en/blogs/deleted,,410,1,removed</pre>
            </p>
            <div class="mb-3">
                <a class="btn btn-link" href="{{ route('dashboard.redirects.template') }}">Download CSV Template</a>
            </div>
            <form method="POST" action="{{ route('dashboard.redirects.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">CSV File</label>
                    <input type="file" name="file" class="form-control" accept=".csv,text/csv" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Status (if not set in the row)</label>
                    <select name="default_status" class="form-select">
                        <option value="301">301 (Permanent)</option>
                        <option value="302">302 (Temporary)</option>
                        <option value="410">410 (Gone)</option>
                    </select>
                </div>
                <button class="btn btn-primary">Import</button>
                <a href="{{ route('dashboard.redirects.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</x-dashboard.layout>

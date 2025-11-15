<x-dashboard.layout title="Redirects">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Redirects</h4>
        <a href="{{ route('dashboard.redirects.create') }}" class="btn btn-primary">Add Redirect</a>
    </div>
    <div class="enhanced-page-header">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($redirects as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td><code>{{ $r->source }}</code></td>
                                <td><code>{{ $r->target }}</code></td>
                                <td>{{ $r->status_code }}</td>
                                <td>{{ $r->is_active ? 'Yes' : 'No' }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.redirects.edit', $r) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('dashboard.redirects.destroy', $r) }}" method="POST"
                                        onsubmit="return confirm('Delete redirect?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No redirects</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $redirects->links() }}</div>
    </div>
</x-dashboard.layout>

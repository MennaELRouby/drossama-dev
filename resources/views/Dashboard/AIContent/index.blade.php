<x-dashboard.layout :title="__('dashboard.ai_content')">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Generate content using AI</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.ai_content') }}</li>
                        </ol>
                        <a href="{{ route('dashboard.ai-content.create') }}" class="btn btn-primary ms-2">
                            <i class="fas fa-plus"></i> Generate new content
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total generations</p>
                                <h4 class="mb-0">{{ $stats['total_generations'] ?? 0 }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div
                                    class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center overflow-hidden">
                                    <span class="avatar-title">
                                        <i class="fas fa-robot font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total cost</p>
                                <h4 class="mb-0">${{ number_format($stats['total_cost'] ?? 0, 4) }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div
                                    class="mini-stat-icon avatar-sm rounded-circle bg-success align-self-center overflow-hidden">
                                    <span class="avatar-title">
                                        <i class="fas fa-dollar-sign font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Average generation time</p>
                                <h4 class="mb-0">{{ round($stats['average_generation_time'] ?? 0, 2) }}ms</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div
                                    class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center overflow-hidden">
                                    <span class="avatar-title">
                                        <i class="fas fa-clock font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">API status</p>
                                <h4 class="mb-0">
                                    @if ($isApiValid)
                                        <span class="badge bg-success">Connected</span>
                                    @else
                                        <span class="badge bg-danger">Not connected</span>
                                    @endif
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div
                                    class="mini-stat-icon avatar-sm rounded-circle {{ $isApiValid ? 'bg-success' : 'bg-danger' }} align-self-center overflow-hidden">
                                    <span class="avatar-title">
                                        <i class="fas fa-wifi font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- قائمة المحتوى -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Number of words</th>
                                        <th>Cost</th>
                                        <th>Status</th>
                                        <th>Generated by</th>
                                        <th>Date</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contents as $content)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">
                                                            <a href="{{ route('dashboard.ai-content.show', $content->id) }}"
                                                                class="text-dark">
                                                                {{ $content->title ?: 'No title' }}
                                                            </a>
                                                            @if ($content->status === 'active' && $content->type === 'article' && $content->target_id)
                                                                <br><small class="text-success">
                                                                    <i class="fas fa-arrow-right me-1"></i>
                                                                    Moved to articles
                                                                </small>
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $content->type }}</span>
                                            </td>
                                            <td>{{ $content->word_count }}</td>
                                            <td>${{ number_format($content->cost, 4) }}</td>
                                            <td>
                                                @if ($content->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($content->status === 'inactive')
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @else
                                                    <span class="badge bg-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $content->admin->name ?? 'Not defined' }}</td>
                                            <td>{{ $content->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="{{ route('dashboard.ai-content.show', $content->id) }}"
                                                                class="dropdown-item">
                                                                <i class="fas fa-eye me-2"></i>View
                                                            </a>
                                                        </li>
                                                        @if ($content->status === 'active' && $content->type === 'article' && $content->target_id)
                                                            <li>
                                                                <a href="{{ route('dashboard.blogs.show', $content->target_id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fas fa-external-link-alt me-2"></i>View
                                                                    the article in the articles section
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a href="#" class="dropdown-item"
                                                                onclick="updateStatus({{ $content->id }}, 'active')">
                                                                <i class="fas fa-check me-2"></i>Activate
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"
                                                                onclick="updateStatus({{ $content->id }}, 'inactive')">
                                                                <i class="fas fa-pause me-2"></i>Stop
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"
                                                                onclick="updateStatus({{ $content->id }}, 'draft')">
                                                                <i class="fas fa-edit me-2"></i>Draft
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item text-danger"
                                                                onclick="deleteContent({{ $content->id }})">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No content generated by AI</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($contents->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $contents->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لتحديث الحالة -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update content status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to update the status of this content?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmUpdateStatus">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal للحذف -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this content? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layout>

@push('scripts')
    <script>
        let currentContentId = null;
        let currentStatus = null;

        function updateStatus(contentId, status) {
            console.log('updateStatus called with:', contentId, status);
            currentContentId = contentId;
            currentStatus = status;

            // Use Bootstrap modal with vanilla JavaScript
            const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
            modal.show();
        }

        function deleteContent(contentId) {
            console.log('deleteContent called with:', contentId);
            currentContentId = contentId;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle status update confirmation
            const confirmUpdateBtn = document.getElementById('confirmUpdateStatus');
            if (confirmUpdateBtn) {
                confirmUpdateBtn.addEventListener('click', function() {
                    if (currentContentId && currentStatus) {
                        console.log('Updating status for content:', currentContentId, 'to:', currentStatus);

                        // Create form data
                        const formData = new FormData();
                        formData.append('status', currentStatus);
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('_method', 'PUT');

                        // Make the request
                        fetch(`{{ url('dashboard/ai-content') }}/${currentContentId}/status`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Response:', data);
                                if (data.success) {
                                    showAlert(data.message || 'Status updated successfully', 'success');
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    showAlert('An error occurred while updating the status', 'danger');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showAlert('An error occurred while updating the status', 'danger');
                            });
                    }

                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('updateStatusModal'));
                    modal.hide();
                });
            }

            // Handle delete confirmation
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (currentContentId) {
                        // Create form for delete request
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ url('dashboard/ai-content') }}/${currentContentId}`;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = '_token';
                        tokenInput.value = '{{ csrf_token() }}';

                        form.appendChild(methodInput);
                        form.appendChild(tokenInput);
                        document.body.appendChild(form);
                        form.submit();
                    }

                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    modal.hide();
                });
            }
        });

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    </script>
@endpush

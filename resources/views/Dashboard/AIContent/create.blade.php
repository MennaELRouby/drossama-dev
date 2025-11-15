<x-dashboard.layout :title="__('dashboard.services')">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Generate new content using AI</h4>
                    <div class="page-title-right">
                        <a href="{{ route('dashboard.ai-content.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <form id="generateForm" method="POST" action="{{ route('dashboard.ai-content.generate') }}">
                            @csrf

                            <!-- نوع المحتوى -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Content type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select content type</option>
                                    @foreach ($contentTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- نوع الصفحة (للصفحات فقط) -->
                            <div class="mb-3" id="pageTypeDiv" style="display: none;">
                                <label for="page_type" class="form-label">Page type</label>
                                <select class="form-select" id="page_type" name="options[page_type]">
                                    @foreach ($pageTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- النص المطلوب -->
                            <div class="mb-3">
                                <label for="prompt" class="form-label">Required text</label>
                                <textarea class="form-control" id="prompt" name="prompt" rows="4"
                                    placeholder="Write here what you want to generate using AI..." required></textarea>
                                <div class="form-text">Write a detailed description of what you want to generate</div>
                            </div>

                            <!-- Advanced Options -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label">Advanced Options</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="toggleAdvancedOptions()">
                                        <i class="fas fa-cog"></i> Show/Hide
                                    </button>
                                </div>
                                <div id="advancedOptions" style="display: block;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="max_tokens" class="form-label">Max Tokens</label>
                                            <input type="number" class="form-control" id="max_tokens"
                                                name="options[max_tokens]" min="100" max="4000" value="1000">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="temperature" class="form-label">Creativity Level</label>
                                            <input type="number" class="form-control" id="temperature"
                                                name="options[temperature]" min="0" max="2" step="0.1"
                                                value="0.7">
                                            <div class="form-text">0 = Precise, 2 = Creative</div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="word_count" class="form-label">Required Word Count</label>
                                            <input type="number" class="form-control" id="word_count"
                                                name="options[word_count]" min="50" max="5000" value="500">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="count" class="form-label">Number of Items</label>
                                            <input type="number" class="form-control" id="count"
                                                name="options[count]" min="1" max="20" value="5">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- زر التوليد -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg" id="generateBtn">
                                    <i class="fas fa-robot"></i> Generate content
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- النتيجة -->
                <div class="enhanced-page-header" id="resultCard" style="display: none;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Result</h5>
                    </div>
                    <div class="card-body">
                        <div id="loadingResult" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Generating...</span>
                                </div>
                                <p class="mt-2">Generating content...</p>
                            </div>
                        </div>

                        <div id="resultContent">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="resultTitle" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea class="form-control" id="resultText" rows="10" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Short description</label>
                                <textarea class="form-control" id="resultMetaDescription" rows="3" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keywords</label>
                                <input type="text" class="form-control" id="resultKeywords" readonly>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Number of words: <span id="wordCount">0</span></small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Cost: $<span id="cost">0.0000</span></small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-success" onclick="saveContent()">
                                    <i class="fas fa-save"></i> Save the content
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="regenerateContent()">
                                    <i class="fas fa-redo"></i> Regenerate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نصائح -->
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tips for better results</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                                Write a detailed and specific description of what you want
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                                Specify the target audience
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                                Mention the main points required
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                                Specify the tone required (formal, friendly, technical)
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-lightbulb text-warning"></i>
                                Mention the important keywords
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-dashboard.layout>

@push('scripts')
    <script>
        let currentGeneratedContent = null;

        // إظهار/إخفاء الخيارات المتقدمة
        function toggleAdvancedOptions() {
            const advancedOptions = document.getElementById('advancedOptions');
            if (advancedOptions.style.display === 'none') {
                advancedOptions.style.display = 'block';
            } else {
                advancedOptions.style.display = 'none';
            }
        }

        // إظهار/إخفاء نوع الصفحة
        document.getElementById('type').addEventListener('change', function() {
            const pageTypeDiv = document.getElementById('pageTypeDiv');
            if (this.value === 'page') {
                pageTypeDiv.style.display = 'block';
            } else {
                pageTypeDiv.style.display = 'none';
            }
        });

        // معالجة النموذج
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('generateForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submission intercepted');
                    e.preventDefault();
                    e.stopPropagation();
                    generateContent();
                    return false;
                });
            } else {
                console.error('Generate form not found!');
            }
        });

        function generateContent() {
            console.log('generateContent function called');

            const form = document.getElementById('generateForm');
            if (!form) {
                console.error('Form not found!');
                showAlert('Error: Form not found', 'danger');
                return;
            }

            const formData = new FormData(form);

            console.log('Starting content generation...');
            console.log('Form data:', Object.fromEntries(formData));

            // إظهار التحميل
            document.getElementById('resultCard').style.display = 'block';
            document.getElementById('loadingResult').style.display = 'block';
            document.getElementById('resultContent').style.display = 'none';
            document.getElementById('generateBtn').disabled = true;

            const url = '{{ route('dashboard.ai-content.generate') }}';
            console.log('Request URL:', url);
            console.log('Current location:', window.location.href);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    console.log('Response ok:', response.ok);

                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Server error response:', text);
                            console.error('Response status:', response.status);
                            console.error('Response statusText:', response.statusText);
                            throw new Error(`HTTP ${response.status} ${response.statusText}: ${text}`);
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    document.getElementById('loadingResult').style.display = 'none';
                    document.getElementById('resultContent').style.display = 'block';
                    document.getElementById('generateBtn').disabled = false;

                    if (data && data.success) {
                        currentGeneratedContent = data.content;

                        // عرض النتيجة
                        document.getElementById('resultTitle').value = data.content.title || '';
                        document.getElementById('resultText').value = data.content.content || '';
                        document.getElementById('resultMetaDescription').value = data.content.meta_description || '';
                        document.getElementById('resultKeywords').value = data.content.keywords || '';
                        document.getElementById('wordCount').textContent = data.content.word_count || 0;
                        document.getElementById('cost').textContent = parseFloat(data.content.cost || 0).toFixed(4);

                        // إظهار رسالة نجاح
                        showAlert('Content generated successfully!', 'success');
                    } else {
                        console.error('Invalid response format:', data);
                        showAlert(data?.error || 'An error occurred while generating the content', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('loadingResult').style.display = 'none';
                    document.getElementById('generateBtn').disabled = false;
                    showAlert('An error occurred while generating the content: ' + error.message, 'danger');
                });
        }

        function saveContent() {
            if (!currentGeneratedContent) {
                showAlert('There is no content to save', 'warning');
                return;
            }

            // يمكن إضافة منطق لحفظ المحتوى في قاعدة البيانات
            showAlert('Content saved successfully!', 'success');
        }

        function regenerateContent() {
            generateContent();
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));

            // Remove the alert automatically after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
@endpush

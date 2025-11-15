<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AIGeneratedContent;
use App\Services\AI\ContentGenerationService;
use App\Services\AI\ImageGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AIContentController extends Controller
{
    protected $aiService;
    protected $imageService;

    public function __construct(ContentGenerationService $aiService, ImageGenerationService $imageService)
    {
        $this->aiService = $aiService;
        $this->imageService = $imageService;
    }

    /**
     * عرض صفحة توليد المحتوى
     */
    public function index()
    {
        $contents = AIGeneratedContent::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = AIGeneratedContent::getUsageStats('month');
        $isApiValid = $this->aiService->validateApiKey();

        return view('Dashboard.AIContent.index', compact('contents', 'stats', 'isApiValid'));
    }

    /**
     * عرض صفحة توليد محتوى جديد
     */
    public function create()
    {
        $contentTypes = [
            'article' => 'مقال',
            'page' => 'صفحة',
            'seo' => 'محتوى SEO',
            'title' => 'عنوان',
            'description' => 'وصف',
            'keywords' => 'كلمات مفتاحية'
        ];

        $pageTypes = [
            'about' => 'من نحن',
            'services' => 'الخدمات',
            'contact' => 'اتصل بنا',
            'privacy' => 'سياسة الخصوصية',
            'terms' => 'الشروط والأحكام'
        ];

        return view('Dashboard.AIContent.create', compact('contentTypes', 'pageTypes'));
    }

    /**
     * توليد محتوى جديد
     */
    public function generate(Request $request)
    {
        // Debug logging
        Log::info('AI Content Generation Request Started', [
            'request_data' => $request->all(),
            'auth_check' => auth()->check(),
            'admin_guard' => auth()->guard('admin')->check(),
            'user_id' => auth()->id(),
            'admin_id' => auth()->guard('admin')->id()
        ]);

        try {
            // Different validation rules for image generation
            if ($request->type === 'image_generation') {
                $request->validate([
                    'type' => 'required|string',
                    'prompt' => 'required|string|max:2000',
                    'style' => 'nullable|string|in:realistic,digital-art,illustration,cartoon,photography,abstract',
                    'size' => 'nullable|string|in:512x512,1024x1024,1024x1792',
                    'options' => 'array',
                    'options.quality' => 'nullable|string|in:standard,hd',
                    'options.style' => 'nullable|string'
                ]);
            } else {
                $request->validate([
                    'type' => 'required|string',
                    'prompt' => 'required|string|max:2000',
                    'options' => 'array',
                    'options.max_tokens' => 'nullable|integer|min:10|max:4000',
                    'options.temperature' => 'nullable|numeric|min:0|max:2',
                    'options.word_count' => 'nullable|integer|min:50|max:5000',
                    'options.count' => 'nullable|integer|min:1|max:20'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for AI content generation', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }

        try {
            $startTime = microtime(true);
            
            $result = $this->generateContent($request->type, $request->prompt, $request->options ?? [], $request);
            
            $endTime = microtime(true);
            $generationTime = ($endTime - $startTime) * 1000; // بالمللي ثانية

            if ($result['success']) {
                // حفظ المحتوى المُنشأ
                $content = AIGeneratedContent::create([
                    'title' => $result['title'] ?? null,
                    'content' => $result['content'],
                    'type' => $request->type,
                    'prompt' => $request->prompt,
                    'options' => $request->options ?? [],
                    'usage_data' => $result['usage'] ?? [],
                    'model_used' => $result['model'] ?? null,
                    'generated_by' => Auth::guard('admin')->id() ?? 1, // Fallback to admin ID 1 if not authenticated
                    'meta_description' => $result['meta_description'] ?? null,
                    'keywords' => $result['keywords'] ?? null,
                    'word_count' => str_word_count(strip_tags($result['content'])),
                    'generation_time' => now(),
                    'cost' => $this->calculateCost($result['usage'] ?? []),
                ]);

                return response()->json([
                    'success' => true,
                    'content' => $content,
                    'generation_time' => round($generationTime, 2),
                    'message' => 'تم توليد المحتوى بنجاح'
                ]);
            }

            // For image generation, return the enhanced prompt even if generation failed
            if ($request->type === 'image_generation') {
                Log::info('Returning image generation response', ['response' => $result]);
                return response()->json($result, 200); // Always return 200 for image generation
            }

            return response()->json([
                'success' => false,
                'error' => $result['error']
            ], 400);

        } catch (\Exception $e) {
            Log::error('AI Content Generation Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء توليد المحتوى'
            ], 500);
        }
    }

    /**
     * عرض تفاصيل المحتوى المُنشأ
     */
    public function show(AIGeneratedContent $content)
    {
        return view('Dashboard.AIContent.show', compact('content'));
    }

    /**
     * تحديث حالة المحتوى
     */
    public function updateStatus(Request $request, AIGeneratedContent $content)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,draft'
        ]);

        $content->updateStatus($request->status);

        $message = 'تم تحديث حالة المحتوى بنجاح';
        
        // إذا تم نقل المحتوى إلى المقالات، أضف رسالة إضافية
        if ($request->status === 'active' && $content->type === 'article' && $content->target_id) {
            $message .= ' وتم نقل المقال إلى قسم المقالات';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'blog_id' => $content->target_id ?? null
        ]);
    }

    /**
     * حذف المحتوى
     */
    public function destroy(AIGeneratedContent $content)
    {
        $content->delete();

        return redirect()->route('dashboard.ai-content.index')
            ->with('success', 'تم حذف المحتوى بنجاح');
    }

    /**
     * تطبيق المحتوى على نموذج معين
     */
    public function applyToModel(Request $request, AIGeneratedContent $content)
    {
        $request->validate([
            'target_model' => 'required|string',
            'target_id' => 'required|integer'
        ]);

        $content->update([
            'target_model' => $request->target_model,
            'target_id' => $request->target_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق المحتوى بنجاح'
        ]);
    }

    /**
     * الحصول على إحصائيات الاستخدام
     */
    public function stats(Request $request)
    {
        $period = $request->get('period', 'month');
        $stats = AIGeneratedContent::getUsageStats($period);

        return response()->json($stats);
    }

    /**
     * التحقق من صحة API Key
     */
    public function validateApi()
    {
        $isValid = $this->aiService->validateApiKey();
        
        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'API Key صحيح' : 'API Key غير صحيح'
        ]);
    }

    /**
     * الحصول على معلومات الاستخدام من Claude AI
     */
    public function usageInfo()
    {
        $usage = $this->aiService->getUsageInfo();
        
        return response()->json($usage);
    }

    /**
     * حفظ الصورة المولدة كصورة مقال
     */
    public function saveImageToBlog(Request $request)
    {
        Log::info('Save image to blog request', [
            'request_data' => $request->all()
        ]);
        
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'image_url' => 'required|string', // Accept both URLs and storage paths
            'type' => 'required|in:main,icon',
            'prompt' => 'nullable|string'
        ]);

        try {
            $blog = \App\Models\Blog::findOrFail($request->blog_id);
            
            // Handle both external URLs and local storage paths
            if (filter_var($request->image_url, FILTER_VALIDATE_URL)) {
                // External URL - download it
                $imageContent = \Illuminate\Support\Facades\Http::withOptions([
                    'verify' => false // For local development
                ])->get($request->image_url)->body();
            } else {
                // Local storage path - read the file directly
                $storagePath = str_replace('/storage/', '', $request->image_url);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                    $imageContent = \Illuminate\Support\Facades\Storage::disk('public')->get($storagePath);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'الصورة المطلوبة غير موجودة'
                    ], 404);
                }
            }
            
            // Generate filename
            $extension = pathinfo(parse_url($request->image_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'blog_' . $request->type . '_' . $blog->id . '_' . time() . '.' . $extension;
            
            // Determine storage path based on image type
            if ($request->type === 'main') {
                $storagePath = 'blogs/' . $filename;
                $dbPath = $filename; // Path stored in database (just filename)
                $field = 'image';
            } else {
                $storagePath = 'blogs/' . $filename;
                $dbPath = $filename; // Path stored in database (just filename)
                $field = 'icon';
            }
            
            // Ensure directory exists
            $directory = dirname($storagePath);
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($directory)) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($directory);
            }
            
            // Save image directly without compression (to avoid version conflicts)
            \Illuminate\Support\Facades\Storage::disk('public')->put($storagePath, $imageContent);
            
            // Delete old image if exists
            if ($blog->$field && \Illuminate\Support\Facades\Storage::disk('public')->exists('blogs/' . $blog->$field)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('blogs/' . $blog->$field);
            }
            
            // Update blog with correct path format
            $blog->update([
                $field => $dbPath
            ]);
            
            // Log the action
            Log::info('AI Generated Image saved to blog', [
                'blog_id' => $blog->id,
                'image_type' => $request->type,
                'filename' => $filename,
                'prompt' => $request->prompt
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $request->type === 'main' 
                    ? 'تم حفظ الصورة كصورة رئيسية للمقال بنجاح'
                    : 'تم حفظ الصورة كأيقونة للمقال بنجاح',
                'image_path' => \Illuminate\Support\Facades\Storage::disk('public')->url('blogs/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to save AI generated image to blog: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء حفظ الصورة'
            ], 500);
        }
    }

    /**
     * حفظ الصورة المولدة كصورة خدمة
     */
    public function saveImageToService(Request $request)
    {
        Log::info('Save image to service request', [
            'request_data' => $request->all()
        ]);
        
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'image_url' => 'required|string', // Accept both URLs and storage paths
            'image_type' => 'required|in:main,icon',
            'prompt' => 'nullable|string'
        ]);

        try {
            $service = \App\Models\Service::findOrFail($request->service_id);
            
            // Handle both external URLs and local storage paths
            if (filter_var($request->image_url, FILTER_VALIDATE_URL)) {
                // External URL - download it
                $imageContent = \Illuminate\Support\Facades\Http::withOptions([
                    'verify' => false // For local development
                ])->get($request->image_url)->body();
            } else {
                // Local storage path - read the file directly
                $storagePath = str_replace('/storage/', '', $request->image_url);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                    $imageContent = \Illuminate\Support\Facades\Storage::disk('public')->get($storagePath);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'الصورة المطلوبة غير موجودة'
                    ], 404);
                }
            }
            
            // Generate filename
            $extension = pathinfo(parse_url($request->image_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'service_' . $request->image_type . '_' . $service->id . '_' . time() . '.' . $extension;
            
            // Determine storage path based on image type
            if ($request->image_type === 'main') {
                $storagePath = 'services/' . $filename;
                $dbPath = $filename; // Path stored in database (just filename)
                $field = 'image';
            } else {
                $storagePath = 'services/' . $filename;
                $dbPath = $filename; // Path stored in database (just filename)
                $field = 'icon';
            }
            
            // Ensure directory exists
            $directory = dirname($storagePath);
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($directory)) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($directory);
            }
            
            // Save image directly without compression (to avoid version conflicts)
            \Illuminate\Support\Facades\Storage::disk('public')->put($storagePath, $imageContent);
            
            // Delete old image if exists
            if ($service->$field && \Illuminate\Support\Facades\Storage::disk('public')->exists('services/' . $service->$field)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('services/' . $service->$field);
            }
            
            // Update service with correct path format
            $service->update([
                $field => $dbPath
            ]);
            
            // Log the action
            Log::info('AI Generated Image saved to service', [
                'service_id' => $service->id,
                'image_type' => $request->image_type,
                'filename' => $filename,
                'prompt' => $request->prompt
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $request->image_type === 'main' 
                    ? 'تم حفظ الصورة كصورة رئيسية للخدمة بنجاح'
                    : 'تم حفظ الصورة كأيقونة للخدمة بنجاح',
                'image_path' => \Illuminate\Support\Facades\Storage::disk('public')->url('services/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to save AI generated image to service: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء حفظ الصورة'
            ], 500);
        }
    }

    /**
     * توليد المحتوى حسب النوع
     */
    protected function generateContent(string $type, string $prompt, array $options = [], $request = null): array
    {
        switch ($type) {
            case 'article':
                return $this->aiService->generateArticle($prompt, $options);
            
            case 'page':
                $pageType = $options['page_type'] ?? 'about';
                return $this->aiService->generatePageContent($pageType, $options);
            
            case 'seo':
                return $this->aiService->generateSEOContent($prompt, $options);
            
            case 'title':
                return $this->aiService->generateTitle($prompt, $options['content_type'] ?? 'article');
            
            case 'description':
                $maxWords = $options['max_words'] ?? 50;
                return $this->aiService->generateDescription($prompt, $maxWords);
            
            case 'keywords':
                $count = $options['count'] ?? 5;
                return $this->aiService->generateKeywords($prompt, $count);
            
            case 'image_generation':
                // Merge request parameters for image generation
                $imageOptions = array_merge($options, [
                    'style' => $request ? ($request->style ?? 'realistic') : 'realistic',
                    'size' => $request ? ($request->size ?? '1024x1024') : '1024x1024'
                ]);
                return $this->generateImage($prompt, $imageOptions);
                
            case 'service_content':
                return $this->aiService->generateText($prompt, $options);
                
            case 'blog_content':
                return $this->generateBlogContent($prompt, $options);
            
            default:
                return $this->aiService->generateText($prompt, $options);
        }
    }

    /**
     * توليد محتوى المقالات
     */
    protected function generateBlogContent(string $prompt, array $options = []): array
    {
        $contentType = $options['content_type'] ?? 'detailed_article';
        $language = $options['language'] ?? 'ar';
        
        // Create specific prompts for different blog content types
        $contentPrompts = [
            'detailed_article' => "اكتب مقالاً تفصيلياً ومفيداً عن: {$prompt}. يجب أن يكون المقال شاملاً ومنظماً بعناوين فرعية واضحة ومحتوى قيم للقارئ.",
            'news_article' => "اكتب مقالاً إخبارياً عن: {$prompt}. استخدم أسلوباً صحفياً واضحاً ومباشراً مع التركيز على الأحداث والوقائع.",
            'tutorial_guide' => "اكتب دليلاً تعليمياً مفصلاً عن: {$prompt}. قدم خطوات واضحة ونصائح عملية مع أمثلة محددة.",
            'seo_article' => "اكتب مقالاً محسناً لمحركات البحث عن: {$prompt}. استخدم الكلمات المفتاحية بشكل طبيعي وقدم محتوى قيماً ومفيداً.",
            'blog_post' => "اكتب تدوينة شخصية ومشاركة عن: {$prompt}. استخدم أسلوباً ودوداً وتفاعلياً مع القراء."
        ];
        
        $enhancedPrompt = $contentPrompts[$contentType] ?? $contentPrompts['detailed_article'];
        
        // Add language instruction
        if ($language === 'en') {
            $enhancedPrompt = str_replace(['اكتب', 'عن:', 'يجب أن', 'استخدم'], 
                                        ['Write', 'about:', 'It should', 'Use'], 
                                        $enhancedPrompt);
            $enhancedPrompt .= " Write the content in English only.";
        } elseif ($language === 'both') {
            $enhancedPrompt .= " اكتب المحتوى باللغة العربية أولاً ثم بالإنجليزية.";
        } else {
            $enhancedPrompt .= " اكتب المحتوى باللغة العربية فقط.";
        }
        
        return $this->aiService->generateText($enhancedPrompt, $options);
    }

    /**
     * توليد صورة باستخدام AI
     */
    protected function generateImage(string $prompt, array $options = []): array
    {
        try {
            Log::info('AI Image Generation Started in Controller', [
                'prompt' => $prompt,
                'options' => $options
            ]);
            
            $result = $this->imageService->generateImage($prompt, $options);
            
            Log::info('AI Image Generation Result', [
                'result' => $result
            ]);
            
            if ($result['success']) {
                return [
                    'success' => true,
                    'content' => $result['image_url'],
                    'image_url' => $result['image_url'],
                    'title' => 'AI Generated Image with Claude Enhancement',
                    'usage' => $result['usage'] ?? [],
                    'model' => $result['service_used'] ?? 'Claude + AI Image Service',
                    'enhanced_prompt' => $result['prompt'] ?? $prompt,
                    'original_prompt' => $result['original_prompt'] ?? $prompt
                ];
            }
            
            // If image generation failed but we have an enhanced prompt, return it
            if (!$result['success'] && isset($result['enhanced_prompt'])) {
                return [
                    'success' => false,
                    'error' => $result['error'],
                    'enhanced_prompt' => $result['enhanced_prompt'],
                    'suggestion' => $result['suggestion'] ?? null,
                    'details' => $result['details'] ?? []
                ];
            }
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Image generation controller error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => 'حدث خطأ أثناء توليد الصورة: ' . $e->getMessage()
            ];
        }
    }

    /**
     * حساب التكلفة
     */
    protected function calculateCost(array $usage): float
    {
        // أسعار Claude AI (Claude 3 Sonnet)
        $inputPrice = 0.003; // لكل 1K tokens
        $outputPrice = 0.015; // لكل 1K tokens

        $inputTokens = $usage['input_tokens'] ?? 0;
        $outputTokens = $usage['output_tokens'] ?? 0;

        $inputCost = ($inputTokens / 1000) * $inputPrice;
        $outputCost = ($outputTokens / 1000) * $outputPrice;

        return $inputCost + $outputCost;
    }

    /**
     * رفع صورة للمحرر
     */
    public function uploadImage(Request $request)
    {
        try {
            // Log the request for debugging
            Log::info('Image upload request received', [
                'has_file' => $request->hasFile('upload'),
                'all_files' => $request->allFiles(),
                'all_input' => $request->all()
            ]);

            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/editor', $filename, 'public');
                
                $url = asset('storage/' . $path);
                
                Log::info('Image uploaded successfully', [
                    'filename' => $filename,
                    'path' => $path,
                    'url' => $url
                ]);
                
                return response()->json([
                    'url' => $url,
                    'uploaded' => true,
                    'fileName' => $filename
                ]);
            }

            return response()->json([
                'uploaded' => false,
                'error' => ['message' => 'لم يتم رفع الملف']
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());
            
            return response()->json([
                'uploaded' => false,
                'error' => ['message' => 'خطأ في التحقق من الملف: ' . implode(', ', $e->validator->errors()->all())]
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            
            return response()->json([
                'uploaded' => false,
                'error' => ['message' => 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage()]
            ], 500);
        }
    }
} 
<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ContentGenerationService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        // Use config() instead of reading .env file directly for security
        $this->apiKey = config('services.claude.api_key');
        $this->baseUrl = config('services.claude.base_url', 'https://api.anthropic.com/v1');
        $this->model = config('services.claude.model', 'claude-3-5-sonnet-20241022');
        
        // Validate required configuration
        if (empty($this->apiKey)) {
            Log::error('Claude API key not configured');
            throw new \Exception('Claude API key not configured. Please check your configuration.');
        }
    }

    /**
     * توليد محتوى عام (يُستخدم من خدمات أخرى)
     */
    public function generateContent(string $prompt, string $type = 'general', string $language = 'ar'): array
    {
        // Set system prompt based on language and type, مع طلب تنسيق HTML
        $systemPrompts = [
            'ar' => [
                'general' => 'أنت مساعد ذكي محترف. اكتب محتوى عالي الجودة باللغة العربية، واستخدم تنسيق HTML (عناوين، فقرات، قوائم، إلخ) ليظهر المحتوى منسقاً في محرر نص منسق.',
                'image_description' => 'أنت خبير في وصف الصور وتطوير prompts للذكاء الاصطناعي. اكتب بالإنجليزية فقط.',
                'service_content' => 'أنت خبير في كتابة محتوى الخدمات. اكتب محتوى جذاب باللغة العربية، واستخدم تنسيق HTML (عناوين، فقرات، قوائم، إلخ) ليظهر المحتوى منسقاً في محرر نص منسق.'
            ],
            'en' => [
                'general' => 'You are a professional AI assistant. Write high-quality content in English, and use HTML formatting (headings, paragraphs, lists, etc.) so the content appears well-formatted in a rich text editor.',
                'image_description' => 'You are an expert image description and AI prompt engineer. Write in English only.',
                'service_content' => 'You are an expert in writing service content. Write engaging content in English, and use HTML formatting (headings, paragraphs, lists, etc.) so the content appears well-formatted in a rich text editor.'
            ]
        ];

        $systemPrompt = $systemPrompts[$language][$type] ?? $systemPrompts['ar']['general'];

        return $this->generateText($prompt, [
            'system_prompt' => $systemPrompt,
            'max_tokens' => 1500,
            'temperature' => 0.7
        ]);
    }

    /**
     * توليد محتوى نصي
     */
    public function generateText(string $prompt, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'anthropic-version' => '2023-06-01',
            ])->withOptions([
                'verify' => config('app.env') !== 'local', // Only disable SSL verification in local development
                'timeout' => 60, // Increased for long content generation
                'connect_timeout' => 15,
            ])->post($this->baseUrl . '/messages', [
                'model' => $this->model,
                'max_tokens' => (int) ($options['max_tokens'] ?? 1000),
                'temperature' => (float) ($options['temperature'] ?? 0.7),
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => ($options['system_prompt'] ?? 'أنت مساعد محتوى محترف. اكتب محتوى عالي الجودة باللغة العربية.') . "\n\n" . $prompt
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'content' => $data['content'][0]['text'] ?? '',
                    'usage' => [
                        'input_tokens' => $data['usage']['input_tokens'] ?? 0,
                        'output_tokens' => $data['usage']['output_tokens'] ?? 0,
                    ],
                    'model' => $data['model'] ?? $this->model
                ];
            }

            return [
                'success' => false,
                'error' => 'فشل في توليد المحتوى: ' . $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Claude AI Content Generation Error: ' . $e->getMessage());
            
            // Provide specific error messages
            $errorMessage = 'خطأ في الاتصال بخدمة Claude AI: ';
            
            if (str_contains($e->getMessage(), 'timeout') || str_contains($e->getMessage(), 'Maximum execution time')) {
                $errorMessage = 'انتهت مهلة الاتصال. الرجاء المحاولة مرة أخرى أو تقليل طول النص المطلوب.';
            } elseif (str_contains($e->getMessage(), 'Connection refused') || str_contains($e->getMessage(), 'Could not resolve host')) {
                $errorMessage = 'فشل في الاتصال بخدمة Claude AI. تأكد من اتصال الإنترنت.';
            } elseif (str_contains($e->getMessage(), 'Unauthorized') || str_contains($e->getMessage(), '401')) {
                $errorMessage = 'مفتاح API غير صحيح. تأكد من إعدادات Claude AI.';
            } else {
                $errorMessage .= $e->getMessage();
            }
            
            return [
                'success' => false,
                'error' => $errorMessage
            ];
        }
    }

    /**
     * توليد عنوان للمحتوى
     */
    public function generateTitle(string $content, string $type = 'article'): array
    {
        $prompt = "اكتب عنوان جذاب ومختصر للمحتوى التالي (نوع المحتوى: {$type}):\n\n{$content}";
        
        return $this->generateText($prompt, [
            'max_tokens' => 100,
            'temperature' => 0.8
        ]);
    }

    /**
     * توليد وصف مختصر
     */
    public function generateDescription(string $content, int $maxWords = 50): array
    {
        $prompt = "اكتب وصف مختصر للمحتوى التالي (أقل من {$maxWords} كلمة):\n\n{$content}";
        
        return $this->generateText($prompt, [
            'max_tokens' => 150,
            'temperature' => 0.6
        ]);
    }

    /**
     * توليد كلمات مفتاحية
     */
    public function generateKeywords(string $content, int $count = 5): array
    {
        $prompt = "استخرج {$count} كلمات مفتاحية من المحتوى التالي (فصل بينها بفواصل):\n\n{$content}";
        
        return $this->generateText($prompt, [
            'max_tokens' => 100,
            'temperature' => 0.5
        ]);
    }

    /**
     * توليد محتوى مقال
     */
    public function generateArticle(string $topic, array $options = []): array
    {
        $prompt = "اكتب مقال شامل عن: {$topic}\n\n";
        $prompt .= "المتطلبات:\n";
        $prompt .= "- استخدم لغة عربية واضحة ومفهومة\n";
        $prompt .= "- اكتب مقدمة وجسم المقال وخاتمة\n";
        $prompt .= "- استخدم عناوين فرعية مناسبة\n";
        $prompt .= "- اكتب محتوى مفيد ومفصل\n";
        
        if (isset($options['word_count'])) {
            $prompt .= "- عدد الكلمات المطلوب: {$options['word_count']}\n";
        }

        $result = $this->generateText($prompt, [
            'max_tokens' => (int) ($options['max_tokens'] ?? 2000),
            'temperature' => (float) ($options['temperature'] ?? 0.7)
        ]);

        if ($result['success']) {
            // توليد عنوان للمقال
            $titleResult = $this->generateTitle($result['content'], 'article');
            if ($titleResult['success']) {
                $result['title'] = $titleResult['content'];
            }

            // توليد وصف مختصر
            $descResult = $this->generateDescription($result['content'], 30);
            if ($descResult['success']) {
                $result['meta_description'] = $descResult['content'];
            }

            // توليد كلمات مفتاحية
            $keywordsResult = $this->generateKeywords($result['content'], 5);
            if ($keywordsResult['success']) {
                $result['keywords'] = $keywordsResult['content'];
            }
        }

        return $result;
    }

    /**
     * توليد محتوى صفحة
     */
    public function generatePageContent(string $pageType, array $options = []): array
    {
        $prompts = [
            'about' => 'اكتب محتوى صفحة "من نحن" شامل ومهني يتضمن تاريخ الشركة ورؤيتها ورسالتها وقيمها',
            'services' => 'اكتب محتوى صفحة الخدمات يتضمن وصف مفصل للخدمات المقدمة ومميزاتها',
            'contact' => 'اكتب محتوى صفحة التواصل يتضمن معلومات التواصل وأوقات العمل',
            'privacy' => 'اكتب سياسة خصوصية شاملة ومفصلة',
            'terms' => 'اكتب شروط وأحكام شاملة للموقع'
        ];

        $prompt = $prompts[$pageType] ?? 'اكتب محتوى صفحة شامل ومفيد';
        
        return $this->generateText($prompt, [
            'max_tokens' => (int) ($options['max_tokens'] ?? 1500),
            'temperature' => (float) ($options['temperature'] ?? 0.6)
        ]);
    }

    /**
     * توليد محتوى SEO
     */
    public function generateSEOContent(string $topic, array $options = []): array
    {
        $prompt = "اكتب محتوى SEO محسن للكلمة المفتاحية: {$topic}\n\n";
        $prompt .= "المتطلبات:\n";
        $prompt .= "- استخدم الكلمة المفتاحية بشكل طبيعي\n";
        $prompt .= "- اكتب محتوى مفيد ومفصل\n";
        $prompt .= "- استخدم عناوين فرعية مناسبة\n";
        $prompt .= "- اكتب وصف meta مناسب\n";
        $prompt .= "- اقترح كلمات مفتاحية ذات صلة\n";

        $result = $this->generateText($prompt, [
            'max_tokens' => (int) ($options['max_tokens'] ?? 1500),
            'temperature' => (float) ($options['temperature'] ?? 0.7)
        ]);

        if ($result['success']) {
            // توليد meta description
            $metaResult = $this->generateDescription($result['content'], 25);
            if ($metaResult['success']) {
                $result['meta_description'] = $metaResult['content'];
            }

            // توليد كلمات مفتاحية
            $keywordsResult = $this->generateKeywords($result['content'], 8);
            if ($keywordsResult['success']) {
                $result['keywords'] = $keywordsResult['content'];
            }
        }

        return $result;
    }

    /**
     * التحقق من صحة API Key
     */
    public function validateApiKey(): bool
    {
        if (empty($this->apiKey)) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'anthropic-version' => '2023-06-01',
            ])->withOptions([
                'verify' => config('app.env') !== 'local', // Only disable SSL verification in local development
                'timeout' => 60, // Increased for long content generation
                'connect_timeout' => 15,
            ])->post($this->baseUrl . '/messages', [
                'model' => $this->model,
                'max_tokens' => 10,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'test'
                    ]
                ]
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * توليد نص alt للصورة باستخدام AI
     */
    public function generateAltText(string $imageDescription, string $context = '', string $language = 'ar'): array
    {
        $prompt = $language === 'ar' 
            ? "اكتب نص alt مناسب لـ SEO للصورة التالية: {$imageDescription}"
            : "Write SEO-friendly alt text for the following image: {$imageDescription}";
            
        if ($context) {
            $prompt .= $language === 'ar' 
                ? "\n\nالسياق: {$context}"
                : "\n\nContext: {$context}";
        }
        
        $prompt .= $language === 'ar'
            ? "\n\nاكتب نص alt مختصر ووصفي ومحسن لمحركات البحث (أقل من 125 حرف)."
            : "\n\nWrite concise, descriptive, and SEO-optimized alt text (under 125 characters).";

        return $this->generateText($prompt, [
            'max_tokens' => 100,
            'temperature' => 0.6,
            'system_prompt' => $language === 'ar' 
                ? 'أنت خبير في كتابة نصوص alt للصور محسنة لـ SEO.'
                : 'You are an expert in writing SEO-optimized alt text for images.'
        ]);
    }

    /**
     * الحصول على معلومات الاستخدام
     */
    public function getUsageInfo(): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
            ])->withOptions([
                'verify' => config('app.env') !== 'local', // Only disable SSL verification in local development
                'timeout' => 60, // Increased for long content generation
                'connect_timeout' => 15,
            ])->get($this->baseUrl . '/usage');

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'فشل في الحصول على معلومات الاستخدام'];
        } catch (\Exception $e) {
            return ['error' => 'خطأ في الاتصال: ' . $e->getMessage()];
        }
    }
} 
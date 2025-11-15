<?php

namespace App\Console\Commands;

use App\Models\AIGeneratedContent;
use App\Models\Admin;
use App\Services\AI\ContentGenerationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateAIContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:generate-content 
                            {type : نوع المحتوى (article, page, seo, title, description, keywords)}
                            {prompt : النص المطلوب}
                            {--admin-id= : ID للمدير}
                            {--max-tokens=1000 : الحد الأقصى للكلمات}
                            {--temperature=0.7 : درجة الإبداع}
                            {--word-count=500 : عدد الكلمات المطلوب}
                            {--page-type=about : نوع الصفحة (للصفحات فقط)}
                            {--save : حفظ المحتوى في قاعدة البيانات}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'توليد محتوى بواسطة AI من سطر الأوامر';

    protected $aiService;

    public function __construct(ContentGenerationService $aiService)
    {
        parent::__construct();
        $this->aiService = $aiService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $prompt = $this->argument('prompt');
        $adminId = $this->option('admin-id');
        $save = $this->option('save');

        // التحقق من صحة API Key
        if (!$this->aiService->validateApiKey()) {
            $this->error('API Key غير صحيح أو غير متوفر');
            return 1;
        }

        // الحصول على المدير
        $admin = null;
        if ($adminId) {
            $admin = Admin::find($adminId);
            if (!$admin) {
                $this->error('المدير غير موجود');
                return 1;
            }
        } else {
            $admin = Admin::first();
            if (!$admin) {
                $this->error('لا يوجد مدير في النظام');
                return 1;
            }
        }

        $this->info("جاري توليد محتوى من نوع: {$type}");
        $this->info("النص المطلوب: {$prompt}");

        // تجهيز الخيارات
        $options = [
            'max_tokens' => (int) $this->option('max-tokens'),
            'temperature' => (float) $this->option('temperature'),
            'word_count' => (int) $this->option('word-count'),
        ];

        if ($type === 'page') {
            $options['page_type'] = $this->option('page-type');
        }

        try {
            $startTime = microtime(true);
            
            // توليد المحتوى
            $result = $this->generateContent($type, $prompt, $options);
            
            $endTime = microtime(true);
            $generationTime = ($endTime - $startTime) * 1000;

            if ($result['success']) {
                $this->info('تم توليد المحتوى بنجاح!');
                $this->newLine();
                
                // عرض النتيجة
                $this->displayResult($result, $generationTime);

                // حفظ المحتوى إذا كان مطلوب
                if ($save) {
                    $content = AIGeneratedContent::create([
                        'title' => $result['title'] ?? null,
                        'content' => $result['content'],
                        'type' => $type,
                        'prompt' => $prompt,
                        'options' => $options,
                        'usage_data' => $result['usage'] ?? [],
                        'model_used' => $result['model'] ?? null,
                        'generated_by' => $admin->id,
                        'meta_description' => $result['meta_description'] ?? null,
                        'keywords' => $result['keywords'] ?? null,
                        'word_count' => str_word_count(strip_tags($result['content'])),
                        'generation_time' => now(),
                        'cost' => $this->calculateCost($result['usage'] ?? []),
                    ]);

                    $this->info("تم حفظ المحتوى في قاعدة البيانات (ID: {$content->id})");
                }

                return 0;
            } else {
                $this->error('فشل في توليد المحتوى: ' . $result['error']);
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('حدث خطأ: ' . $e->getMessage());
            Log::error('AI Content Generation Command Error: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * توليد المحتوى حسب النوع
     */
    protected function generateContent(string $type, string $prompt, array $options = []): array
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
                $maxWords = $options['word_count'] ?? 50;
                return $this->aiService->generateDescription($prompt, $maxWords);
            
            case 'keywords':
                $count = $options['count'] ?? 5;
                return $this->aiService->generateKeywords($prompt, $count);
            
            default:
                return $this->aiService->generateText($prompt, $options);
        }
    }

    /**
     * عرض النتيجة
     */
    protected function displayResult(array $result, float $generationTime): void
    {
        $this->line('=' . str_repeat('=', 50));
        
        if (isset($result['title'])) {
            $this->info('العنوان:');
            $this->line($result['title']);
            $this->newLine();
        }

        $this->info('المحتوى:');
        $this->line($result['content']);
        $this->newLine();

        if (isset($result['meta_description'])) {
            $this->info('الوصف المختصر:');
            $this->line($result['meta_description']);
            $this->newLine();
        }

        if (isset($result['keywords'])) {
            $this->info('الكلمات المفتاحية:');
            $this->line($result['keywords']);
            $this->newLine();
        }

        $this->info('معلومات التوليد:');
        $this->line("وقت التوليد: " . round($generationTime, 2) . "ms");
        $this->line("عدد الكلمات: " . str_word_count(strip_tags($result['content'])));
        
        if (isset($result['usage'])) {
            $this->line("Prompt Tokens: " . ($result['usage']['prompt_tokens'] ?? 0));
            $this->line("Completion Tokens: " . ($result['usage']['completion_tokens'] ?? 0));
            $this->line("Total Tokens: " . ($result['usage']['total_tokens'] ?? 0));
        }

        if (isset($result['model'])) {
            $this->line("النموذج المستخدم: " . $result['model']);
        }

        $cost = $this->calculateCost($result['usage'] ?? []);
        $this->line("التكلفة: $" . number_format($cost, 4));
        
        $this->line('=' . str_repeat('=', 50));
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
} 
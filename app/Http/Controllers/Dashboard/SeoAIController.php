<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AI\ContentGenerationService;
use App\Models\Dashboard\AboutUs;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SeoAIController extends Controller
{
    protected $contentService;

    public function __construct(ContentGenerationService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function generateSEO(Request $request)
    {
        try {
            $page = $request->input('page');

            // Get page context based on page type
            $context = $this->getPageContext($page);

            // Generate content for both languages
            $content = [
                'en' => $this->generateLanguageContent($page, $context, 'en'),
                'ar' => $this->generateLanguageContent($page, $context, 'ar')
            ];

            return response()->json([
                'success' => true,
                'content' => $content
            ]);
        } catch (\Exception $e) {
            Log::error('SEO Content Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('dashboard.generation_failed')
            ], 500);
        }
    }

    public function generateField(Request $request)
    {
        try {
            $page = $request->input('page');
            $lang = $request->input('lang');
            $field = $request->input('field');

            // Get page context
            $context = $this->getPageContext($page);

            // Generate specific field content
            $content = $this->generateFieldContent($page, $context, $lang, $field);

            return response()->json([
                'success' => true,
                'content' => $content
            ]);
        } catch (\Exception $e) {
            Log::error('SEO Field Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('dashboard.generation_failed')
            ], 500);
        }
    }

    protected function getPageContext($page)
    {
        $settings = Setting::firstOrNew();

        // Get relevant content based on page type
        switch ($page) {
            case 'home':
                return [
                    'type' => 'home',
                    'name' => $settings->site_name ?? 'SiteName',
                    'description_en' => $settings->site_description_en ?? '',
                    'description_ar' => $settings->site_description_ar ?? '',
                    'keywords' => [
                        'web development',
                        'digital solutions',
                        'IT services',
                        'software development',
                        'technology consulting'
                    ]
                ];

            case 'about':
                $about = AboutUs::firstOrNew();
                return [
                    'type' => 'about',
                    'title_en' => $about->title_en ?? '',
                    'title_ar' => $about->title_ar ?? '',
                    'text_en' => strip_tags($about->text_en ?? ''),
                    'text_ar' => strip_tags($about->text_ar ?? ''),
                    'vision_en' => $about->vision_en ?? '',
                    'vision_ar' => $about->vision_ar ?? '',
                    'mission_en' => $about->mission_en ?? '',
                    'mission_ar' => $about->mission_ar ?? ''
                ];

            case 'contact':
                return [
                    'type' => 'contact',
                    'company_name' => $settings->site_name ?? 'S',
                    'email' => $settings->site_email ?? '',
                    'phone' => $settings->site_phone ?? '',
                    'address_en' => $settings->address_en ?? '',
                    'address_ar' => $settings->address_ar ?? ''
                ];

            case 'blog':
                $recentBlogs = Blog::active()
                    ->latest()
                    ->take(5)
                    ->get(['title_en', 'title_ar', 'short_desc_en', 'short_desc_ar'])
                    ->toArray();
                return [
                    'type' => 'blog',
                    'recent_posts' => $recentBlogs,
                    'total_posts' => Blog::active()->count()
                ];

            case 'service':
                $services = Service::active()
                    ->take(5)
                    ->get(['name_en', 'name_ar', 'short_desc_en', 'short_desc_ar'])
                    ->toArray();
                return [
                    'type' => 'service',
                    'services' => $services,
                    'total_services' => Service::active()->count()
                ];

            case 'products':
                $products = Product::active()
                    ->take(5)
                    ->get(['name_en', 'name_ar', 'short_desc_en', 'short_desc_ar'])
                    ->toArray();
                return [
                    'type' => 'products',
                    'products' => $products,
                    'total_products' => Product::active()->count()
                ];

            default:
                throw new \Exception('Invalid page type');
        }
    }

    protected function generateLanguageContent($page, $context, $lang)
    {
        $titlePrompt = $this->buildTitlePrompt($page, $context, $lang);
        $descPrompt = $this->buildDescriptionPrompt($page, $context, $lang);

        return [
            'title' => $this->contentService->generateContent($titlePrompt, 'general', $lang)['content'] ?? '',
            'description' => $this->contentService->generateContent($descPrompt, 'general', $lang)['content'] ?? ''
        ];
    }

    protected function generateFieldContent($page, $context, $lang, $field)
    {
        $prompt = $field === 'title'
            ? $this->buildTitlePrompt($page, $context, $lang)
            : $this->buildDescriptionPrompt($page, $context, $lang);

        $result = $this->contentService->generateContent($prompt, 'general', $lang);
        return $result['content'] ?? '';
    }

    protected function buildTitlePrompt($page, $context, $lang)
    {
        $prompt = '';

        if ($lang === 'en') {
            switch ($page) {
                case 'home':
                    $prompt = "Generate an SEO-optimized title tag for {$context['name']}'s homepage. Include the company name and main service offering. The title should be compelling and between 50-60 characters.\n\n";
                    $prompt .= "Context: {$context['description_en']}\n";
                    $prompt .= "Keywords: " . implode(', ', $context['keywords']);
                    break;

                case 'about':
                    $prompt = "Create an SEO-optimized title tag for {$context['name']}'s About page. Include company name and highlight expertise/experience.\n\n";
                    $prompt .= "Context: Vision: {$context['vision_en']}\n";
                    $prompt .= "Mission: {$context['mission_en']}";
                    break;

                case 'contact':
                    $prompt = "Write an SEO-optimized title tag for {$context['company_name']}'s Contact page. Encourage user engagement.\n\n";
                    $prompt .= "Context: Company provides professional IT and digital solutions. Located in {$context['address_en']}";
                    break;

                case 'blog':
                    $prompt = "Generate an SEO-optimized title tag for the blog section. Highlight industry insights and expertise.\n\n";
                    $prompt .= "Context: {$context['total_posts']} articles covering digital transformation, technology, and industry insights.";
                    break;

                case 'service':
                    $prompt = "Create an SEO-optimized title tag for the services page. Highlight main service offerings.\n\n";
                    $prompt .= "Context: Offering {$context['total_services']} professional services including: ";
                    $prompt .= collect($context['services'])->pluck('name_en')->implode(', ');
                    break;

                case 'products':
                    $prompt = "Write an SEO-optimized title tag for the products page. Highlight product range and benefits.\n\n";
                    $prompt .= "Context: Offering {$context['total_products']} digital products including: ";
                    $prompt .= collect($context['products'])->pluck('name_en')->implode(', ');
                    break;
            }
        } else {
            switch ($page) {
                case 'home':
                    $prompt = "اكتب عنوان SEO محسن للصفحة الرئيسية لـ {$context['name']}. يجب أن يتضمن اسم الشركة والخدمة الرئيسية. العنوان يجب أن يكون جذابًا وبين 50-60 حرفًا.\n\n";
                    $prompt .= "السياق: {$context['description_ar']}\n";
                    break;

                case 'about':
                    $prompt = "اكتب عنوان SEO محسن لصفحة من نحن لـ {$context['name']}. يجب أن يتضمن اسم الشركة ويسلط الضوء على الخبرة.\n\n";
                    $prompt .= "السياق: الرؤية: {$context['vision_ar']}\n";
                    $prompt .= "الرسالة: {$context['mission_ar']}";
                    break;

                case 'contact':
                    $prompt = "اكتب عنوان SEO محسن لصفحة اتصل بنا لـ {$context['company_name']}. شجع تفاعل المستخدم.\n\n";
                    $prompt .= "السياق: الشركة تقدم حلول تقنية ورقمية احترافية. العنوان: {$context['address_ar']}";
                    break;

                case 'blog':
                    $prompt = "اكتب عنوان SEO محسن لقسم المدونة. سلط الضوء على رؤى وخبرات المجال.\n\n";
                    $prompt .= "السياق: {$context['total_posts']} مقال يغطي التحول الرقمي والتكنولوجيا ورؤى الصناعة.";
                    break;

                case 'service':
                    $prompt = "اكتب عنوان SEO محسن لصفحة الخدمات. سلط الضوء على الخدمات الرئيسية.\n\n";
                    $prompt .= "السياق: نقدم {$context['total_services']} خدمة احترافية تشمل: ";
                    $prompt .= collect($context['services'])->pluck('name_ar')->implode('، ');
                    break;

                case 'products':
                    $prompt = "اكتب عنوان SEO محسن لصفحة المنتجات. سلط الضوء على نطاق وفوائد المنتجات.\n\n";
                    $prompt .= "السياق: نقدم {$context['total_products']} منتج رقمي يشمل: ";
                    $prompt .= collect($context['products'])->pluck('name_ar')->implode('، ');
                    break;
            }
        }

        return $prompt;
    }

    protected function buildDescriptionPrompt($page, $context, $lang)
    {
        $prompt = '';

        if ($lang === 'en') {
            switch ($page) {
                case 'home':
                    $prompt = "Write an SEO meta description for {$context['name']}'s homepage. Highlight unique value proposition and main services. Include a call to action.\n\n";
                    $prompt .= "Context: {$context['description_en']}\n";
                    $prompt .= "Keywords: " . implode(', ', $context['keywords']);
                    break;

                case 'about':
                    $prompt = "Create an SEO meta description for the About page. Highlight company expertise, experience, and values.\n\n";
                    $prompt .= "Context: Vision: {$context['vision_en']}\n";
                    $prompt .= "Mission: {$context['mission_en']}";
                    break;

                case 'contact':
                    $prompt = "Write an SEO meta description for the Contact page. Encourage engagement and highlight response time.\n\n";
                    $prompt .= "Context: Professional IT and digital solutions provider. Located in {$context['address_en']}";
                    break;

                case 'blog':
                    $prompt = "Generate an SEO meta description for the blog section. Highlight content value and expertise sharing.\n\n";
                    $prompt .= "Context: {$context['total_posts']} articles covering digital transformation, technology trends, and industry insights.";
                    break;

                case 'service':
                    $prompt = "Create an SEO meta description for the services page. Highlight service range and benefits.\n\n";
                    $prompt .= "Context: Professional services including: ";
                    $prompt .= collect($context['services'])->pluck('name_en')->implode(', ');
                    break;

                case 'products':
                    $prompt = "Write an SEO meta description for the products page. Highlight product benefits and solutions.\n\n";
                    $prompt .= "Context: Digital products including: ";
                    $prompt .= collect($context['products'])->pluck('name_en')->implode(', ');
                    break;
            }
        } else {
            switch ($page) {
                case 'home':
                    $prompt = "اكتب وصف ميتا SEO للصفحة الرئيسية لـ {$context['name']}. سلط الضوء على القيمة الفريدة والخدمات الرئيسية. أضف دعوة للعمل.\n\n";
                    $prompt .= "السياق: {$context['description_ar']}";
                    break;

                case 'about':
                    $prompt = "اكتب وصف ميتا SEO لصفحة من نحن. سلط الضوء على خبرة الشركة وقيمها.\n\n";
                    $prompt .= "السياق: الرؤية: {$context['vision_ar']}\n";
                    $prompt .= "الرسالة: {$context['mission_ar']}";
                    break;

                case 'contact':
                    $prompt = "اكتب وصف ميتا SEO لصفحة اتصل بنا. شجع التواصل وسلط الضوء على سرعة الاستجابة.\n\n";
                    $prompt .= "السياق: مزود حلول تقنية ورقمية احترافية. العنوان: {$context['address_ar']}";
                    break;

                case 'blog':
                    $prompt = "اكتب وصف ميتا SEO لقسم المدونة. سلط الضوء على قيمة المحتوى ومشاركة الخبرات.\n\n";
                    $prompt .= "السياق: {$context['total_posts']} مقال يغطي التحول الرقمي واتجاهات التكنولوجيا ورؤى الصناعة.";
                    break;

                case 'service':
                    $prompt = "اكتب وصف ميتا SEO لصفحة الخدمات. سلط الضوء على نطاق وفوائد الخدمات.\n\n";
                    $prompt .= "السياق: خدمات احترافية تشمل: ";
                    $prompt .= collect($context['services'])->pluck('name_ar')->implode('، ');
                    break;

                case 'products':
                    $prompt = "اكتب وصف ميتا SEO لصفحة المنتجات. سلط الضوء على فوائد وحلول المنتجات.\n\n";
                    $prompt .= "السياق: منتجات رقمية تشمل: ";
                    $prompt .= collect($context['products'])->pluck('name_ar')->implode('، ');
                    break;
            }
        }

        return $prompt;
    }
}

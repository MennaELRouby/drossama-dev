<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use DOMDocument;
use DOMXPath;
use DateTime;

class SeoTestingController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.url', 'http://mepicom.test'), '/');

        // For local development, prefer HTTP over HTTPS to avoid SSL issues
        if (app()->environment('local') && strpos($this->baseUrl, 'https://') === 0) {
            $this->baseUrl = str_replace('https://', 'http://', $this->baseUrl);
        }

        // Remove any language prefix from baseUrl to avoid conflicts
        $this->baseUrl = preg_replace('/\/(en|ar)\/?$/', '', $this->baseUrl);

        // If the site redirects HTTP to HTTPS, use HTTPS
        if (app()->environment('production') || app()->environment('staging')) {
            $this->baseUrl = str_replace('http://', 'https://', $this->baseUrl);
        }

        Log::info("SEO Testing - Base URL configured", [
            'base_url' => $this->baseUrl,
            'environment' => app()->environment(),
            'original_url' => config('app.url')
        ]);
    }

    /**
     * Display SEO testing dashboard
     */
    public function index()
    {
        // Get recent test results if they exist
        $recentResults = $this->getRecentTestResults();

        return view('Dashboard.seo-testing.index', compact('recentResults'));
    }

    /**
     * Run comprehensive SEO test
     */
    public function runComprehensiveTest(Request $request)
    {
        try {
            // Set longer timeout for comprehensive test
            set_time_limit(600); // 10 minutes

            Log::info("SEO Testing - Starting comprehensive test");

            // الصفحات الثابتة
            $staticPages = [
                'home' => '/',
                'about' => '/about-us',
                'contact' => '/contact-us',
                'blog' => '/blog',
                'services' => '/services',
                'products' => '/products'
            ];

            Log::info("SEO Testing - Testing static pages", ['count' => count($staticPages)]);

            // الصفحات الديناميكية
            $dynamicPages = $this->getDynamicPages();

            Log::info("SEO Testing - Testing dynamic pages", ['count' => count($dynamicPages)]);

            $allPages = array_merge($staticPages, $dynamicPages);

            $results = [];
            $totalScore = 0;
            $maxScore = 0;

            foreach ($allPages as $name => $path) {
                try {
                    Log::info("SEO Testing - Testing page: {$name}", ['path' => $path]);
                    $pageResult = $this->testPage($name, $path);
                    $results[$name] = $pageResult;

                    $totalScore += $pageResult['score'];
                    $maxScore += $pageResult['max_score'];

                    Log::info("SEO Testing - Page completed: {$name}", [
                        'score' => $pageResult['score'],
                        'max_score' => $pageResult['max_score'],
                        'percentage' => $pageResult['percentage'] ?? 0
                    ]);
                } catch (\Exception $e) {
                    Log::error("SEO Testing - Error testing page: {$name}", [
                        'error' => $e->getMessage(),
                        'path' => $path
                    ]);

                    // Add error result for this page
                    $results[$name] = [
                        'name' => $name,
                        'url' => $this->baseUrl . $path,
                        'accessible' => false,
                        'score' => 0,
                        'max_score' => 1,
                        'percentage' => 0,
                        'tests' => [
                            ['name' => 'Page Loading', 'passed' => false, 'details' => 'Error: ' . $e->getMessage()]
                        ]
                    ];
                }
            }

            Log::info("SEO Testing - Testing technical SEO");

            // Test technical elements
            $technicalResults = $this->testTechnicalSEO();
            $results['technical'] = $technicalResults;
            $totalScore += $technicalResults['score'];
            $maxScore += $technicalResults['max_score'];

            $overallScore = $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 1) : 0;

            Log::info("SEO Testing - Generating recommendations");

            $finalResults = [
                'overall_score' => $overallScore,
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'pages' => $results,
                'timestamp' => Carbon::now(),
                'recommendations' => $this->generateRecommendations($results)
            ];

            // Cache results for 1 hour
            cache(['seo_test_results' => $finalResults], 3600);

            Log::info("SEO Testing - Comprehensive test completed successfully", [
                'overall_score' => $overallScore,
                'total_pages' => count($results),
                'total_score' => $totalScore,
                'max_score' => $maxScore
            ]);

            return response()->json([
                'success' => true,
                'results' => $finalResults
            ]);
        } catch (\Exception $e) {
            Log::error("SEO Testing - Comprehensive test failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to run comprehensive test: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Run quick SEO test
     */
    public function runQuickTest(Request $request)
    {
        try {
            $url = $request->get('url', $this->baseUrl);
            $result = $this->testPage('quick_test', parse_url($url, PHP_URL_PATH) ?: '/');

            return response()->json([
                'success' => true,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to run quick test: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test sitemap functionality
     */
    public function testSitemap()
    {
        try {
            $sitemapUrls = [
                $this->baseUrl . '/sitemap.xml'
            ];

            $result = [
                'found' => false,
                'url' => null,
                'sitemap_count' => 0,
                'url_count' => 0,
                'last_modified' => null,
                'errors' => []
            ];

            foreach ($sitemapUrls as $url) {
                $content = $this->fetchContent($url);

                if ($content && (strpos($content, '<?xml') === 0 || strpos($content, '<sitemapindex') !== false)) {
                    $result['found'] = true;
                    $result['url'] = $url;

                    // Parse sitemap
                    if (strpos($content, '<sitemapindex') !== false) {
                        preg_match_all('/<sitemap>.*?<loc>(.*?)<\/loc>/s', $content, $matches);
                        $result['sitemap_count'] = count($matches[1]);
                    } else {
                        preg_match_all('/<loc>(.*?)<\/loc>/', $content, $matches);
                        $result['url_count'] = count($matches[1]);
                    }

                    // Get last modified
                    preg_match('/<lastmod>(.*?)<\/lastmod>/', $content, $lastModMatches);
                    if (!empty($lastModMatches[1])) {
                        $result['last_modified'] = $lastModMatches[1];
                    }

                    break;
                }
            }

            return response()->json([
                'success' => true,
                'sitemap' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to test sitemap: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get SEO recommendations
     */
    public function getRecommendations()
    {
        try {
            // Get recent test results to generate specific recommendations
            $recentResults = $this->getRecentTestResults();

            if ($recentResults && isset($recentResults['pages']) && is_array($recentResults['pages'])) {
                $recommendations = $this->generateRecommendations($recentResults['pages']);
            } else {
                // Fallback to general recommendations
                $recommendations = [
                    'high_priority' => [
                        'Fix missing meta descriptions on key pages',
                        'Add structured data markup for better rich snippets',
                        'Optimize page load speeds (target under 3 seconds)',
                        'Ensure all images have descriptive alt tags'
                    ],
                    'medium_priority' => [
                        'Improve internal linking structure',
                        'Add Open Graph tags for social media sharing',
                        'Optimize title tag lengths (30-60 characters)',
                        'Create XML sitemap if missing'
                    ],
                    'low_priority' => [
                        'Add Twitter Card meta tags',
                        'Implement breadcrumb navigation',
                        'Add FAQ schema markup where applicable',
                        'Monitor Core Web Vitals metrics'
                    ]
                ];
            }

            // Ensure all arrays exist and are arrays
            $recommendations['high_priority'] = is_array($recommendations['high_priority'] ?? null) ? $recommendations['high_priority'] : [];
            $recommendations['medium_priority'] = is_array($recommendations['medium_priority'] ?? null) ? $recommendations['medium_priority'] : [];
            $recommendations['low_priority'] = is_array($recommendations['low_priority'] ?? null) ? $recommendations['low_priority'] : [];

            return response()->json([
                'success' => true,
                'recommendations' => $recommendations
            ]);
        } catch (\Exception $e) {
            Log::error("SEO Testing - Failed to get recommendations", ['error' => $e->getMessage()]);

            // Return safe fallback recommendations
            return response()->json([
                'success' => true,
                'recommendations' => [
                    'high_priority' => ['Run a comprehensive SEO test first to get specific recommendations'],
                    'medium_priority' => ['Check your website for basic SEO issues'],
                    'low_priority' => ['Consider implementing advanced SEO features']
                ]
            ]);
        }
    }

    /**
     * Test individual page SEO
     */
    private function testPage(string $pageName, string $path): array
    {
        // Ensure path starts with / and remove any double slashes
        $path = '/' . ltrim($path, '/');
        $path = preg_replace('/\/+/', '/', $path);

        // Build full URL
        $url = rtrim($this->baseUrl, '/') . $path;

        Log::info("SEO Testing - Testing page", [
            'page_name' => $pageName,
            'path' => $path,
            'full_url' => $url,
            'base_url' => $this->baseUrl
        ]);

        $html = $this->fetchContent($url);

        if (!$html) {
            Log::warning("SEO Testing - Page not accessible", [
                'page_name' => $pageName,
                'url' => $url,
                'path' => $path
            ]);

            return [
                'name' => $pageName,
                'url' => $url,
                'accessible' => false,
                'score' => 0,
                'max_score' => 1,
                'percentage' => 0,
                'tests' => [
                    ['name' => 'Page Loading', 'passed' => false, 'details' => 'Failed to load page']
                ]
            ];
        }

        $tests = [];
        $score = 0;
        $maxScore = 0;

        // Test meta tags
        $metaTests = $this->testMetaTags($html);
        $tests = array_merge($tests, $metaTests['tests']);
        $score += $metaTests['score'];
        $maxScore += $metaTests['max_score'];

        // Test page structure
        $structureTests = $this->testPageStructure($html);
        $tests = array_merge($tests, $structureTests['tests']);
        $score += $structureTests['score'];
        $maxScore += $structureTests['max_score'];

        // Test social media tags
        $socialTests = $this->testSocialMediaTags($html);
        $tests = array_merge($tests, $socialTests['tests']);
        $score += $socialTests['score'];
        $maxScore += $socialTests['max_score'];

        // إضافة اختبارات خاصة بالصفحات الديناميكية
        if (
            strpos($pageName, 'blog_') === 0 ||
            strpos($pageName, 'service_') === 0 ||
            strpos($pageName, 'project_') === 0 ||
            strpos($pageName, 'product_') === 0
        ) {

            $dynamicTests = $this->testDynamicPageContent($html, $this->getTypeFromPageName($pageName));
            $tests = array_merge($tests, $dynamicTests['tests']);
            $score += $dynamicTests['score'];
            $maxScore += $dynamicTests['max_score'];
        }

        // إضافة اختبارات جودة المحتوى
        $contentQualityTests = $this->testContentQuality($html);
        $tests = array_merge($tests, $contentQualityTests['tests']);
        $score += $contentQualityTests['score'];
        $maxScore += $contentQualityTests['max_score'];

        // إضافة اختبارات SEO الدولية
        $internationalTests = $this->testInternationalSEO($html);
        $tests = array_merge($tests, $internationalTests['tests']);
        $score += $internationalTests['score'];
        $maxScore += $internationalTests['max_score'];

        Log::info("SEO Testing - Page test completed", [
            'page_name' => $pageName,
            'url' => $url,
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $maxScore > 0 ? round(($score / $maxScore) * 100, 1) : 0
        ]);

        return [
            'name' => $pageName,
            'url' => $url,
            'accessible' => true,
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $maxScore > 0 ? round(($score / $maxScore) * 100, 1) : 0,
            'tests' => $tests
        ];
    }

    /**
     * Test meta tags
     */
    private function testMetaTags(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $tests = [];
        $score = 0;
        $maxScore = 6;

        // Title tag
        $title = $xpath->query('//title')->item(0);
        if ($title && strlen($title->textContent) > 0) {
            $titleLength = strlen($title->textContent);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $tests[] = ['name' => 'Title Tag', 'passed' => true, 'details' => "Good length: {$titleLength} chars"];
                $score++;
            } else {
                $tests[] = ['name' => 'Title Tag', 'passed' => false, 'details' => "Poor length: {$titleLength} chars"];
            }
        } else {
            $tests[] = ['name' => 'Title Tag', 'passed' => false, 'details' => 'Missing title tag'];
        }

        // Meta description
        $description = $xpath->query('//meta[@name="description"]/@content')->item(0);
        if ($description && strlen($description->value) > 0) {
            $descLength = strlen($description->value);
            if ($descLength >= 120 && $descLength <= 160) {
                $tests[] = ['name' => 'Meta Description', 'passed' => true, 'details' => "Good length: {$descLength} chars"];
                $score++;
            } else {
                $tests[] = ['name' => 'Meta Description', 'passed' => false, 'details' => "Poor length: {$descLength} chars"];
            }
        } else {
            $tests[] = ['name' => 'Meta Description', 'passed' => false, 'details' => 'Missing meta description'];
        }

        // Robots meta
        $robots = $xpath->query('//meta[@name="robots"]/@content')->item(0);
        if ($robots) {
            $tests[] = ['name' => 'Robots Meta', 'passed' => true, 'details' => "Content: {$robots->value}"];
            $score++;
        } else {
            $tests[] = ['name' => 'Robots Meta', 'passed' => false, 'details' => 'Missing robots meta'];
        }

        // Canonical URL
        $canonical = $xpath->query('//link[@rel="canonical"]/@href')->item(0);
        if ($canonical) {
            $tests[] = ['name' => 'Canonical URL', 'passed' => true, 'details' => 'Canonical URL present'];
            $score++;
        } else {
            $tests[] = ['name' => 'Canonical URL', 'passed' => false, 'details' => 'Missing canonical URL'];
        }

        // Viewport meta
        $viewport = $xpath->query('//meta[@name="viewport"]/@content')->item(0);
        if ($viewport) {
            $tests[] = ['name' => 'Viewport Meta', 'passed' => true, 'details' => 'Mobile viewport configured'];
            $score++;
        } else {
            $tests[] = ['name' => 'Viewport Meta', 'passed' => false, 'details' => 'Missing viewport meta'];
        }

        // Schema markup
        $hasSchema = strpos($html, 'application/ld+json') !== false;
        if ($hasSchema) {
            $tests[] = ['name' => 'Schema Markup', 'passed' => true, 'details' => 'Structured data found'];
            $score++;
        } else {
            $tests[] = ['name' => 'Schema Markup', 'passed' => false, 'details' => 'No structured data'];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Test page structure
     */
    private function testPageStructure(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $tests = [];
        $score = 0;
        $maxScore = 3;

        // H1 tag
        $h1Tags = $xpath->query('//h1');
        if ($h1Tags->length === 1) {
            $tests[] = ['name' => 'H1 Tag', 'passed' => true, 'details' => 'Single H1 found'];
            $score++;
        } else {
            $tests[] = ['name' => 'H1 Tag', 'passed' => false, 'details' => "Found {$h1Tags->length} H1 tags"];
        }

        // Heading hierarchy
        $headings = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');
        if ($headings->length > 0) {
            $tests[] = ['name' => 'Heading Structure', 'passed' => true, 'details' => "{$headings->length} headings found"];
            $score++;
        } else {
            $tests[] = ['name' => 'Heading Structure', 'passed' => false, 'details' => 'No headings found'];
        }

        // Alt tags
        $images = $xpath->query('//img');
        $imagesWithAlt = $xpath->query('//img[@alt]');
        if ($images->length > 0) {
            $altPercentage = round(($imagesWithAlt->length / $images->length) * 100);
            if ($altPercentage >= 90) {
                $tests[] = ['name' => 'Image Alt Tags', 'passed' => true, 'details' => "{$altPercentage}% images have alt tags"];
                $score++;
            } else {
                $tests[] = ['name' => 'Image Alt Tags', 'passed' => false, 'details' => "Only {$altPercentage}% images have alt tags"];
            }
        } else {
            $tests[] = ['name' => 'Image Alt Tags', 'passed' => true, 'details' => 'No images found'];
            $score++;
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Test social media tags
     */
    private function testSocialMediaTags(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $tests = [];
        $score = 0;
        $maxScore = 2;

        // Open Graph tags
        $ogTags = ['og:title', 'og:description', 'og:image', 'og:url'];
        $ogFound = 0;
        foreach ($ogTags as $tag) {
            $element = $xpath->query("//meta[@property='$tag']/@content")->item(0);
            if ($element && strlen($element->value) > 0) {
                $ogFound++;
            }
        }

        if ($ogFound >= 3) {
            $tests[] = ['name' => 'Open Graph Tags', 'passed' => true, 'details' => "{$ogFound}/4 OG tags found"];
            $score++;
        } else {
            $tests[] = ['name' => 'Open Graph Tags', 'passed' => false, 'details' => "Only {$ogFound}/4 OG tags found"];
        }

        // Twitter Cards
        $twitterTags = ['twitter:card', 'twitter:title', 'twitter:description', 'twitter:image'];
        $twitterFound = 0;
        foreach ($twitterTags as $tag) {
            $element = $xpath->query("//meta[@name='$tag']/@content")->item(0);
            if ($element && strlen($element->value) > 0) {
                $twitterFound++;
            }
        }

        if ($twitterFound >= 3) {
            $tests[] = ['name' => 'Twitter Cards', 'passed' => true, 'details' => "{$twitterFound}/4 Twitter tags found"];
            $score++;
        } else {
            $tests[] = ['name' => 'Twitter Cards', 'passed' => false, 'details' => "Only {$twitterFound}/4 Twitter tags found"];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Test technical SEO aspects
     */
    private function testTechnicalSEO(): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 0;

        try {
            // Test sitemap using internal method
            $sitemap = $this->testSitemapInternal();
            if ($sitemap['found']) {
                $tests[] = ['name' => 'XML Sitemap', 'passed' => true, 'details' => "Found at {$sitemap['url']}"];
                $score++;
            } else {
                $tests[] = ['name' => 'XML Sitemap', 'passed' => false, 'details' => 'Not found'];
            }
            $maxScore++;
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Sitemap test failed", ['error' => $e->getMessage()]);
            $tests[] = ['name' => 'XML Sitemap', 'passed' => false, 'details' => 'Test failed'];
            $maxScore++;
        }

        try {
            // Test robots.txt
            $robotsContent = $this->fetchContent($this->baseUrl . '/robots.txt');
            if ($robotsContent) {
                $tests[] = ['name' => 'Robots.txt', 'passed' => true, 'details' => 'File exists'];
                $score++;
            } else {
                $tests[] = ['name' => 'Robots.txt', 'passed' => false, 'details' => 'File not found'];
            }
            $maxScore++;
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Robots.txt test failed", ['error' => $e->getMessage()]);
            $tests[] = ['name' => 'Robots.txt', 'passed' => false, 'details' => 'Test failed'];
            $maxScore++;
        }

        try {
            // Test page speed (basic)
            $homePageContent = $this->fetchContent($this->baseUrl);
            if ($homePageContent) {
                $contentLength = strlen($homePageContent);
                if ($contentLength < 500000) { // Less than 500KB (more realistic for modern websites)
                    $tests[] = ['name' => 'Page Size', 'passed' => true, 'details' => round($contentLength / 1024, 1) . ' KB'];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Page Size', 'passed' => false, 'details' => round($contentLength / 1024, 1) . ' KB (too large - consider optimizing)'];
                }
                $maxScore++;
            }
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Page speed test failed", ['error' => $e->getMessage()]);
            $tests[] = ['name' => 'Page Size', 'passed' => false, 'details' => 'Test failed'];
            $maxScore++;
        }

        // Test HTTPS
        if (strpos($this->baseUrl, 'https://') === 0) {
            $tests[] = ['name' => 'HTTPS', 'passed' => true, 'details' => 'Secure connection'];
            $score++;
        } else {
            $tests[] = ['name' => 'HTTPS', 'passed' => false, 'details' => 'Not using HTTPS'];
        }
        $maxScore++;

        // Test security headers
        $securityHeaders = $this->testSecurityHeaders();
        $tests = array_merge($tests, $securityHeaders['tests']);
        $score += $securityHeaders['score'];
        $maxScore += $securityHeaders['max_score'];

        // Test advanced technical features
        $advancedTests = $this->testAdvancedTechnicalFeatures();
        $tests = array_merge($tests, $advancedTests['tests']);
        $score += $advancedTests['score'];
        $maxScore += $advancedTests['max_score'];

        $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100, 1) : 0;

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore, 'percentage' => $percentage];
    }

    /**
     * Test security headers
     */
    private function testSecurityHeaders(): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 4;

        try {
            $response = $this->makeHttpRequest($this->baseUrl, 'HEAD');
            $headers = $response['headers'] ?? [];

            // HSTS Header
            if (isset($headers['Strict-Transport-Security'])) {
                $tests[] = ['name' => 'HSTS Header', 'passed' => true, 'details' => 'HSTS enabled'];
                $score++;
            } else {
                $tests[] = ['name' => 'HSTS Header', 'passed' => false, 'details' => 'HSTS not found'];
            }

            // X-Frame-Options
            if (isset($headers['X-Frame-Options'])) {
                $tests[] = ['name' => 'X-Frame-Options', 'passed' => true, 'details' => 'Clickjacking protection'];
                $score++;
            } else {
                $tests[] = ['name' => 'X-Frame-Options', 'passed' => false, 'details' => 'No clickjacking protection'];
            }

            // X-Content-Type-Options
            if (isset($headers['X-Content-Type-Options'])) {
                $tests[] = ['name' => 'X-Content-Type-Options', 'passed' => true, 'details' => 'MIME type protection'];
                $score++;
            } else {
                $tests[] = ['name' => 'X-Content-Type-Options', 'passed' => false, 'details' => 'MIME type protection missing'];
            }

            // Referrer-Policy
            if (isset($headers['Referrer-Policy'])) {
                $tests[] = ['name' => 'Referrer-Policy', 'passed' => true, 'details' => 'Referrer policy set'];
                $score++;
            } else {
                $tests[] = ['name' => 'Referrer-Policy', 'passed' => false, 'details' => 'Referrer policy not set'];
            }
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Security headers test failed", ['error' => $e->getMessage()]);
            $tests = [
                ['name' => 'HSTS Header', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'X-Frame-Options', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'X-Content-Type-Options', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Referrer-Policy', 'passed' => false, 'details' => 'Test failed']
            ];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Test advanced technical features
     */
    private function testAdvancedTechnicalFeatures(): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 4;

        try {
            $homePageContent = $this->fetchContent($this->baseUrl);
            if ($homePageContent) {
                $dom = new DOMDocument();
                @$dom->loadHTML($homePageContent);
                $xpath = new DOMXPath($dom);

                // Test PWA Manifest
                $manifest = $xpath->query('//link[@rel="manifest"]/@href')->item(0);
                if ($manifest) {
                    $tests[] = ['name' => 'PWA Manifest', 'passed' => true, 'details' => 'PWA manifest found'];
                    $score++;
                } else {
                    $tests[] = ['name' => 'PWA Manifest', 'passed' => false, 'details' => 'No PWA manifest'];
                }

                // Test Service Worker
                $serviceWorker = $xpath->query('//script[contains(text(), "serviceWorker")]')->item(0);
                if ($serviceWorker) {
                    $tests[] = ['name' => 'Service Worker', 'passed' => true, 'details' => 'Service worker detected'];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Service Worker', 'passed' => false, 'details' => 'No service worker'];
                }

                // AMP Support removed - not supported in Egypt

                // Test JSON-LD Schema
                $jsonLd = $xpath->query('//script[@type="application/ld+json"]')->item(0);
                if ($jsonLd) {
                    $tests[] = ['name' => 'JSON-LD Schema', 'passed' => true, 'details' => 'Structured data found'];
                    $score++;
                } else {
                    $tests[] = ['name' => 'JSON-LD Schema', 'passed' => false, 'details' => 'No structured data'];
                }

                // Test Open Graph
                $ogTags = $xpath->query('//meta[starts-with(@property, "og:")]');
                if ($ogTags && $ogTags->length >= 3) {
                    $tests[] = ['name' => 'Open Graph Tags', 'passed' => true, 'details' => "{$ogTags->length} OG tags found"];
                    $score++;
                } else {
                    $ogCount = $ogTags ? $ogTags->length : 0;
                    $tests[] = ['name' => 'Open Graph Tags', 'passed' => false, 'details' => "Only {$ogCount} OG tags found (need 3+)"];
                }
            }
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Advanced technical features test failed", ['error' => $e->getMessage()]);
            $tests = [
                ['name' => 'PWA Manifest', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Service Worker', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'JSON-LD Schema', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Open Graph Tags', 'passed' => false, 'details' => 'Test failed']
            ];
        }

        $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100, 1) : 0;

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore, 'percentage' => $percentage];
    }

    /**
     * Test content quality and readability
     */
    private function testContentQuality(string $html): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 4;

        try {
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // Test content length
            $content = $xpath->query('//main | //article | //div[contains(@class, "content")] | //div[@id="content"]')->item(0);
            if ($content) {
                $textContent = trim($content->textContent);
                $wordCount = str_word_count($textContent);

                if ($wordCount >= 300) {
                    $tests[] = ['name' => 'Content Length', 'passed' => true, 'details' => "{$wordCount} words"];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Content Length', 'passed' => false, 'details' => "Only {$wordCount} words (need 300+)"];
                }
            } else {
                $tests[] = ['name' => 'Content Length', 'passed' => false, 'details' => 'Content area not found'];
            }

            // Test image optimization
            $images = $xpath->query('//img');
            $imagesWithAlt = $xpath->query('//img[@alt]');
            if ($images->length > 0) {
                $altPercentage = round(($imagesWithAlt->length / $images->length) * 100);
                if ($altPercentage >= 80) {
                    $tests[] = ['name' => 'Image Alt Tags', 'passed' => true, 'details' => "{$altPercentage}% have alt tags"];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Image Alt Tags', 'passed' => false, 'details' => "Only {$altPercentage}% have alt tags"];
                }
            } else {
                $tests[] = ['name' => 'Image Alt Tags', 'passed' => true, 'details' => 'No images to test'];
                $score++;
            }

            // Test internal linking
            $internalLinks = $xpath->query('//a[contains(@href, "/") and not(contains(@href, "http"))]');
            $externalLinks = $xpath->query('//a[contains(@href, "http")]');

            if ($internalLinks->length > 0) {
                $tests[] = ['name' => 'Internal Links', 'passed' => true, 'details' => "{$internalLinks->length} internal links"];
                $score++;
            } else {
                $tests[] = ['name' => 'Internal Links', 'passed' => false, 'details' => 'No internal links found'];
            }

            // Test content freshness (last modified date)
            $lastModified = $xpath->query('//meta[@http-equiv="last-modified"]/@content')->item(0);
            if ($lastModified) {
                $lastModDate = new DateTime($lastModified->nodeValue);
                $daysSinceUpdate = (new DateTime())->diff($lastModDate)->days;

                if ($daysSinceUpdate <= 90) {
                    $tests[] = ['name' => 'Content Freshness', 'passed' => true, 'details' => "Updated {$daysSinceUpdate} days ago"];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Content Freshness', 'passed' => false, 'details' => "Updated {$daysSinceUpdate} days ago (old)"];
                }
            } else {
                $tests[] = ['name' => 'Content Freshness', 'passed' => false, 'details' => 'Last modified date not found'];
            }
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Content quality test failed", ['error' => $e->getMessage()]);
            $tests = [
                ['name' => 'Content Length', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Image Alt Tags', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Internal Links', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Content Freshness', 'passed' => false, 'details' => 'Test failed']
            ];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Test international SEO features
     */
    private function testInternationalSEO(string $html): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 3;

        try {
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // Test hreflang tags
            $hreflangTags = $xpath->query('//link[@hreflang]');
            if ($hreflangTags->length > 0) {
                $tests[] = ['name' => 'Hreflang Tags', 'passed' => true, 'details' => "{$hreflangTags->length} language versions"];
                $score++;
            } else {
                $tests[] = ['name' => 'Hreflang Tags', 'passed' => false, 'details' => 'No hreflang tags found'];
            }

            // Test language attribute
            $htmlLang = $xpath->query('//html/@lang')->item(0);
            if ($htmlLang) {
                $tests[] = ['name' => 'HTML Language', 'passed' => true, 'details' => "Language: {$htmlLang->nodeValue}"];
                $score++;
            } else {
                $tests[] = ['name' => 'HTML Language', 'passed' => false, 'details' => 'No language attribute'];
            }

            // Test currency and regional settings
            $currencyMeta = $xpath->query('//meta[@name="currency"]/@content')->item(0);
            $regionMeta = $xpath->query('//meta[@name="region"]/@content')->item(0);

            if ($currencyMeta || $regionMeta) {
                $details = [];
                if ($currencyMeta) $details[] = "Currency: {$currencyMeta->nodeValue}";
                if ($regionMeta) $details[] = "Region: {$regionMeta->nodeValue}";

                $tests[] = ['name' => 'Regional Settings', 'passed' => true, 'details' => implode(', ', $details)];
                $score++;
            } else {
                $tests[] = ['name' => 'Regional Settings', 'passed' => false, 'details' => 'No regional settings found'];
            }
        } catch (\Exception $e) {
            Log::warning("SEO Testing - International SEO test failed", ['error' => $e->getMessage()]);
            $tests = [
                ['name' => 'Hreflang Tags', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'HTML Language', 'passed' => false, 'details' => 'Test failed'],
                ['name' => 'Regional Settings', 'passed' => false, 'details' => 'Test failed']
            ];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Fetch content from URL
     */
    private function fetchContent(string $url): ?string
    {
        // Try HTTPS first, then HTTP if HTTPS fails (common in local development)
        $urls = [$url];
        if (strpos($url, 'https://') === 0) {
            $urls[] = str_replace('https://', 'http://', $url);
        }

        foreach ($urls as $tryUrl) {
            try {
                Log::info("SEO Testing - Attempting to fetch content from: $tryUrl");

                // Use Laravel's HTTP client for better error handling
                $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification for local development
                    'timeout' => 15, // Reduced timeout to avoid hanging
                    'connect_timeout' => 10, // Connection timeout
                    'user-agent' => 'Mozilla/5.0 (compatible; SEO-Testing-Bot/1.0)',
                    'allow_redirects' => true, // Allow redirects
                    'max_redirects' => 3, // Reduced redirects to avoid loops
                ])->get($tryUrl);

                if ($response->successful()) {
                    Log::info("SEO Testing - Successfully fetched content from: $tryUrl", [
                        'status' => $response->status(),
                        'content_length' => strlen($response->body()),
                        'final_url' => $response->effectiveUri()
                    ]);
                    return $response->body();
                }

                Log::warning("SEO Testing - Non-successful response from: $tryUrl", [
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 200)
                ]);
            } catch (\Exception $e) {
                // Log error for debugging
                Log::error("SEO Testing - Failed to fetch content from: $tryUrl", [
                    'error' => $e->getMessage(),
                    'exception_class' => get_class($e)
                ]);
                // Continue to try next URL
            }
        }

        Log::error("SEO Testing - All attempts to fetch content failed for URL: $url");
        return null;
    }

    /**
     * Generate recommendations based on test results
     */
    private function generateRecommendations(array $results): array
    {
        $recommendations = [
            'high_priority' => [],
            'medium_priority' => [],
            'low_priority' => []
        ];

        foreach ($results as $pageName => $pageData) {
            if (!is_array($pageData) || !isset($pageData['tests'])) continue;

            foreach ($pageData['tests'] as $test) {
                if (!$test['passed']) {
                    switch ($test['name']) {
                        case 'Meta Description':
                            $recommendations['high_priority'][] = "Add meta description to {$pageName} page";
                            break;
                        case 'Title Tag':
                            $recommendations['high_priority'][] = "Optimize title tag on {$pageName} page";
                            break;
                        case 'Schema Markup':
                            $recommendations['medium_priority'][] = "Add structured data to {$pageName} page";
                            break;
                        case 'Open Graph Tags':
                            $recommendations['medium_priority'][] = "Add Open Graph tags to {$pageName} page";
                            break;
                        case 'Twitter Cards':
                            $recommendations['low_priority'][] = "Add Twitter Cards to {$pageName} page";
                            break;
                        case 'Content Length':
                            $recommendations['high_priority'][] = "Increase content length on {$pageName} page";
                            break;
                        case 'Content Images':
                            $recommendations['medium_priority'][] = "Add images to {$pageName} page content";
                            break;
                        case 'Internal Links':
                            $recommendations['medium_priority'][] = "Add internal links to {$pageName} page";
                            break;
                        case 'HSTS Header':
                            $recommendations['high_priority'][] = "Enable HSTS header for {$pageName} page";
                            break;
                        case 'X-Frame-Options':
                            $recommendations['high_priority'][] = "Add X-Frame-Options header to {$pageName} page";
                            break;
                        case 'Content Freshness':
                            $recommendations['medium_priority'][] = "Update content on {$pageName} page (content is old)";
                            break;
                        case 'Hreflang Tags':
                            $recommendations['medium_priority'][] = "Add hreflang tags for {$pageName} page";
                            break;
                        case 'PWA Manifest':
                            $recommendations['low_priority'][] = "Add PWA manifest for {$pageName} page";
                            break;
                    }
                }
            }
        }

        // Remove duplicates and ensure all are arrays
        foreach ($recommendations as $priority => $items) {
            $recommendations[$priority] = is_array($items) ? array_values(array_unique($items)) : [];
        }

        // Ensure all arrays exist and are indexed arrays
        $recommendations['high_priority'] = is_array($recommendations['high_priority'] ?? null) ? array_values($recommendations['high_priority']) : [];
        $recommendations['medium_priority'] = is_array($recommendations['medium_priority'] ?? null) ? array_values($recommendations['medium_priority']) : [];
        $recommendations['low_priority'] = is_array($recommendations['low_priority'] ?? null) ? array_values($recommendations['low_priority']) : [];

        return $recommendations;
    }

    /**
     * Get recent test results from cache
     */
    private function getRecentTestResults(): ?array
    {
        return cache('seo_test_results');
    }

    /**
     * Test individual dynamic page
     */
    public function testDynamicPage(Request $request)
    {
        try {
            $type = $request->get('type'); // blog, service, project, product
            $id = $request->get('id');

            $model = $this->getModelByType($type, $id);
            if (!$model) {
                return response()->json([
                    'success' => false,
                    'error' => 'Page not found'
                ], 404);
            }

            $path = $this->getPathByType($type, $model);
            $result = $this->testPage("{$type}_{$id}", $path);

            return response()->json([
                'success' => true,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to test dynamic page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get model by type and ID
     */
    private function getModelByType(string $type, int $id)
    {
        $models = [
            'blog' => \App\Models\Blog::class,
            'service' => \App\Models\Service::class,
            'project' => \App\Models\Project::class,
            'product' => \App\Models\Product::class,
        ];

        if (!isset($models[$type])) {
            return null;
        }

        return $models[$type]::find($id);
    }

    /**
     * Get path by type and model
     */
    private function getPathByType(string $type, $model): string
    {
        // Check if model uses HasJsonTranslations trait
        if (method_exists($model, 'getTranslation')) {
            $slug = $model->getTranslation('slug');
        } else {
            $slug = $model->slug;
        }

        $paths = [
            'blog' => "/blog/{$slug}",
            'service' => "/services/{$slug}",
            'project' => "/projects/{$slug}",
            'product' => "/products/{$slug}",
        ];

        $path = $paths[$type] ?? '/';

        Log::info("SEO Testing - Generated path for dynamic page", [
            'type' => $type,
            'model_id' => $model->id,
            'slug_value' => $slug ?? 'N/A',
            'path' => $path,
            'locale' => app()->getLocale()
        ]);

        return $path;
    }

    /**
     * Get type from page name
     */
    private function getTypeFromPageName(string $pageName): string
    {
        if (strpos($pageName, 'blog_') === 0) return 'blog';
        if (strpos($pageName, 'service_') === 0) return 'service';
        if (strpos($pageName, 'project_') === 0) return 'project';
        if (strpos($pageName, 'product_') === 0) return 'product';

        return 'page';
    }

    /**
     * Test dynamic page content
     */
    private function testDynamicPageContent(string $html, string $type): array
    {
        $tests = [];
        $score = 0;
        $maxScore = 3;

        try {
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // اختبار محتوى الصفحة - استخدام XPath expressions صحيحة
            $contentSelectors = [
                '//main',
                '//article',
                '//div[contains(@class, "content")]',
                '//div[contains(@class, "post-content")]',
                '//div[contains(@class, "entry-content")]',
                '//div[contains(@class, "article-content")]',
                '//div[@id="content"]',
                '//div[@id="main-content"]'
            ];

            $content = null;
            foreach ($contentSelectors as $selector) {
                try {
                    $content = $xpath->query($selector)->item(0);
                    if ($content) break;
                } catch (\Exception $e) {
                    Log::warning("SEO Testing - Invalid XPath selector: {$selector}", ['error' => $e->getMessage()]);
                    continue;
                }
            }

            if ($content && strlen(trim($content->textContent)) > 200) {
                $tests[] = ['name' => 'Content Length', 'passed' => true, 'details' => 'Sufficient content (>200 chars)'];
                $score++;
            } else {
                $tests[] = ['name' => 'Content Length', 'passed' => false, 'details' => 'Insufficient content (<200 chars)'];
            }

            // اختبار الصور في المحتوى
            try {
                $images = $xpath->query('//img');
                if ($images && $images->length > 0) {
                    $tests[] = ['name' => 'Content Images', 'passed' => true, 'details' => "{$images->length} images found"];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Content Images', 'passed' => false, 'details' => 'No images in content'];
                }
            } catch (\Exception $e) {
                Log::warning("SEO Testing - Error testing images", ['error' => $e->getMessage()]);
                $tests[] = ['name' => 'Content Images', 'passed' => false, 'details' => 'Error testing images'];
            }

            // اختبار الروابط الداخلية
            try {
                $internalLinks = $xpath->query('//a[contains(@href, "/") and not(contains(@href, "http"))]');
                if ($internalLinks && $internalLinks->length > 0) {
                    $tests[] = ['name' => 'Internal Links', 'passed' => true, 'details' => "{$internalLinks->length} internal links found"];
                    $score++;
                } else {
                    $tests[] = ['name' => 'Internal Links', 'passed' => false, 'details' => 'No internal links found'];
                }
            } catch (\Exception $e) {
                Log::warning("SEO Testing - Error testing internal links", ['error' => $e->getMessage()]);
                $tests[] = ['name' => 'Internal Links', 'passed' => false, 'details' => 'Error testing internal links'];
            }
        } catch (\Exception $e) {
            Log::error("SEO Testing - Error in testDynamicPageContent", [
                'error' => $e->getMessage(),
                'type' => $type
            ]);

            // Return basic tests if DOM parsing fails
            $tests = [
                ['name' => 'Content Length', 'passed' => false, 'details' => 'Error parsing content'],
                ['name' => 'Content Images', 'passed' => false, 'details' => 'Error parsing content'],
                ['name' => 'Internal Links', 'passed' => false, 'details' => 'Error parsing content']
            ];
        }

        return ['tests' => $tests, 'score' => $score, 'max_score' => $maxScore];
    }

    /**
     * Get dynamic pages for comprehensive testing
     */
    private function getDynamicPages(): array
    {
        $dynamicPages = [];

        try {
            // جلب جميع المقالات النشطة
            if (class_exists(\App\Models\Blog::class)) {
                $recentBlogs = \App\Models\Blog::active()->latest()->get();
                foreach ($recentBlogs as $blog) {
                    // Check if Blog uses HasJsonTranslations trait
                    if (method_exists($blog, 'getTranslation')) {
                        $slug = $blog->getTranslation('slug');
                        $name = $blog->getTranslation('name');
                    } else {
                        $slug = $blog->slug;
                        $name = $blog->title;
                    }

                    if ($slug && !empty(trim($slug))) {
                        $url = "/blog/{$slug}";
                        // Use blog name as key instead of blog_ID for better display
                        $pageName = $name ?: "Blog_{$blog->id}";
                        $dynamicPages[$pageName] = $url;
                        Log::info("SEO Testing - Added blog page for testing", [
                            'blog_id' => $blog->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => $url,
                            'full_url' => $this->baseUrl . $url,
                            'page_name' => $pageName,
                            'locale' => app()->getLocale()
                        ]);
                    } else {
                        Log::warning("SEO Testing - Blog skipped due to missing slug", [
                            'blog_id' => $blog->id,
                            'title' => $name ?? 'N/A',
                            'slug' => $slug ?? 'N/A',
                            'locale' => app()->getLocale()
                        ]);
                    }
                }
            }

            // جلب جميع الخدمات النشطة
            if (class_exists(\App\Models\Service::class)) {
                $services = \App\Models\Service::active()->latest()->get();
                foreach ($services as $service) {
                    // Check if Service uses HasJsonTranslations trait
                    if (method_exists($service, 'getTranslation')) {
                        $slug = $service->getTranslation('slug');
                        $name = $service->getTranslation('name');
                    } else {
                        $slug = $service->slug;
                        $name = $service->title;
                    }

                    if ($slug && !empty(trim($slug))) {
                        $url = "/services/{$slug}";
                        // Use service name as key for better display
                        $pageName = $name ?: "Service_{$service->id}";
                        $dynamicPages[$pageName] = $url;
                        Log::info("SEO Testing - Added service page for testing", [
                            'service_id' => $service->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => $url,
                            'full_url' => $this->baseUrl . $url,
                            'page_name' => $pageName,
                            'locale' => app()->getLocale()
                        ]);
                    } else {
                        Log::warning("SEO Testing - Service skipped due to missing slug", [
                            'service_id' => $service->id,
                            'title' => $name ?? 'N/A',
                            'slug' => $slug ?? 'N/A',
                            'locale' => app()->getLocale()
                        ]);
                    }
                }
            }

            // جلب جميع المشاريع النشطة
            if (class_exists(\App\Models\Project::class)) {
                $projects = \App\Models\Project::active()->latest()->get();
                foreach ($projects as $project) {
                    // Check if Project uses HasJsonTranslations trait
                    if (method_exists($project, 'getTranslation')) {
                        $slug = $project->getTranslation('slug');
                        $name = $project->getTranslation('name');
                    } else {
                        $slug = $project->slug;
                        $name = $project->title;
                    }

                    if ($slug && !empty(trim($slug))) {
                        $url = "/projects/{$slug}";
                        // Use project name as key for better display
                        $pageName = $name ?: "Project_{$project->id}";
                        $dynamicPages[$pageName] = $url;
                        Log::info("SEO Testing - Added project page for testing", [
                            'project_id' => $project->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => $url,
                            'full_url' => $this->baseUrl . $url,
                            'page_name' => $pageName,
                            'locale' => app()->getLocale()
                        ]);
                    } else {
                        Log::warning("SEO Testing - Project skipped due to missing slug", [
                            'project_id' => $project->id,
                            'title' => $name ?? 'N/A',
                            'slug' => $slug ?? 'N/A',
                            'locale' => app()->getLocale()
                        ]);
                    }
                }
            }

            // جلب جميع المنتجات النشطة
            if (class_exists(\App\Models\Product::class)) {
                $products = \App\Models\Product::active()->latest()->get();
                foreach ($products as $product) {
                    // Check if Product uses HasJsonTranslations trait
                    if (method_exists($product, 'getTranslation')) {
                        $slug = $product->getTranslation('slug');
                        $name = $product->getTranslation('name');
                    } else {
                        $slug = $product->slug;
                        $name = $product->title;
                    }

                    if ($slug && !empty(trim($slug))) {
                        $url = "/products/{$slug}";
                        // Use product name as key for better display
                        $pageName = $name ?: "Product_{$product->id}";
                        $dynamicPages[$pageName] = $url;
                        Log::info("SEO Testing - Added product page for testing", [
                            'product_id' => $product->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => $url,
                            'full_url' => $this->baseUrl . $url,
                            'page_name' => $pageName,
                            'locale' => app()->getLocale()
                        ]);
                    } else {
                        Log::warning("SEO Testing - Product skipped due to missing slug", [
                            'product_id' => $product->id,
                            'title' => $name ?? 'N/A',
                            'slug' => $slug ?? 'N/A',
                            'locale' => app()->getLocale()
                        ]);
                    }
                }
            }

            Log::info("SEO Testing - Total dynamic pages found", [
                'total_count' => count($dynamicPages),
                'blog_count' => count(array_filter($dynamicPages, function ($key) {
                    return strpos($key, 'Blog_') === 0 || strpos($key, 'blog_') === 0;
                }, ARRAY_FILTER_USE_KEY)),
                'service_count' => count(array_filter($dynamicPages, function ($key) {
                    return strpos($key, 'Service_') === 0 || strpos($key, 'service_') === 0;
                }, ARRAY_FILTER_USE_KEY)),
                'project_count' => count(array_filter($dynamicPages, function ($key) {
                    return strpos($key, 'Project_') === 0 || strpos($key, 'project_') === 0;
                }, ARRAY_FILTER_USE_KEY)),
                'product_count' => count(array_filter($dynamicPages, function ($key) {
                    return strpos($key, 'Product_') === 0 || strpos($key, 'product_') === 0;
                }, ARRAY_FILTER_USE_KEY)),
                'base_url' => $this->baseUrl,
                'locale' => app()->getLocale()
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the entire test
            Log::warning('Failed to fetch dynamic pages for SEO testing', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $dynamicPages;
    }

    /**
     * Check dynamic pages status
     */
    public function checkDynamicPagesStatus()
    {
        try {
            $status = [];

            // Check Blogs
            if (class_exists(\App\Models\Blog::class)) {
                $blogs = \App\Models\Blog::active()->latest()->get();
                $status['blogs'] = [
                    'count' => $blogs->count(),
                    'items' => $blogs->map(function ($blog) {
                        // Check if Blog uses HasJsonTranslations trait
                        if (method_exists($blog, 'getTranslation')) {
                            $slug = $blog->getTranslation('slug');
                            $name = $blog->getTranslation('name');
                        } else {
                            $slug = $blog->slug;
                            $name = $blog->title;
                        }

                        return [
                            'id' => $blog->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => "/blog/{$slug}",
                            'has_slug' => !empty($slug),
                            'locale' => app()->getLocale()
                        ];
                    })
                ];
            }

            // Check Services
            if (class_exists(\App\Models\Service::class)) {
                $services = \App\Models\Service::active()->latest()->get();
                $status['services'] = [
                    'count' => $services->count(),
                    'items' => $services->map(function ($service) {
                        // Check if Service uses HasJsonTranslations trait
                        if (method_exists($service, 'getTranslation')) {
                            $slug = $service->getTranslation('slug');
                            $name = $service->getTranslation('name');
                        } else {
                            $slug = $service->slug;
                            $name = $service->title;
                        }

                        return [
                            'id' => $service->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => "/services/{$slug}",
                            'has_slug' => !empty($slug),
                            'locale' => app()->getLocale()
                        ];
                    })
                ];
            }

            // Check Projects
            if (class_exists(\App\Models\Project::class)) {
                $projects = \App\Models\Project::active()->latest()->get();
                $status['projects'] = [
                    'count' => $projects->count(),
                    'items' => $projects->map(function ($project) {
                        // Check if Project uses HasJsonTranslations trait
                        if (method_exists($project, 'getTranslation')) {
                            $slug = $project->getTranslation('slug');
                            $name = $project->getTranslation('name');
                        } else {
                            $slug = $project->slug;
                            $name = $project->title;
                        }

                        return [
                            'id' => $project->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => "/projects/{$slug}",
                            'has_slug' => !empty($slug),
                            'locale' => app()->getLocale()
                        ];
                    })
                ];
            }

            // Check Products
            if (class_exists(\App\Models\Product::class)) {
                $products = \App\Models\Product::active()->latest()->get();
                $status['products'] = [
                    'count' => $products->count(),
                    'items' => $products->map(function ($product) {
                        // Check if Product uses HasJsonTranslations trait
                        if (method_exists($product, 'getTranslation')) {
                            $slug = $product->getTranslation('slug');
                            $name = $product->getTranslation('name');
                        } else {
                            $slug = $product->slug;
                            $name = $product->title;
                        }

                        return [
                            'id' => $product->id,
                            'title' => $name,
                            'slug' => $slug,
                            'url' => "/products/{$slug}",
                            'has_slug' => !empty($slug),
                            'locale' => app()->getLocale()
                        ];
                    })
                ];
            }

            return response()->json([
                'success' => true,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to check dynamic pages status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Make HTTP request with custom method
     */
    private function makeHttpRequest(string $url, string $method = 'GET'): array
    {
        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => 15,
                'connect_timeout' => 10,
                'allow_redirects' => true,
                'max_redirects' => 3,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'SEO-Testing-Bot/1.0',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.5',
                    'Accept-Encoding' => 'gzip, deflate',
                    'Connection' => 'keep-alive',
                ]
            ]);

            $response = $client->request($method, $url);

            return [
                'status' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'body' => $response->getBody()->getContents()
            ];
        } catch (\Exception $e) {
            Log::warning("SEO Testing - HTTP request failed", [
                'url' => $url,
                'method' => $method,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Test sitemap internally (for comprehensive testing)
     */
    private function testSitemapInternal(): array
    {
        try {
            $sitemapUrls = [
                $this->baseUrl . '/sitemap.xml'
            ];

            $result = [
                'found' => false,
                'url' => null,
                'sitemap_count' => 0,
                'url_count' => 0,
                'last_modified' => null,
                'errors' => []
            ];

            foreach ($sitemapUrls as $url) {
                $content = $this->fetchContent($url);

                if ($content && (strpos($content, '<?xml') === 0 || strpos($content, '<sitemapindex') !== false)) {
                    $result['found'] = true;
                    $result['url'] = $url;

                    // Parse sitemap
                    if (strpos($content, '<sitemapindex') !== false) {
                        preg_match_all('/<sitemap>.*?<loc>(.*?)<\/loc>/s', $content, $matches);
                        $result['sitemap_count'] = count($matches[1]);
                    } else {
                        preg_match_all('/<loc>(.*?)<\/loc>/', $content, $matches);
                        $result['url_count'] = count($matches[1]);
                    }

                    // Get last modified
                    preg_match('/<lastmod>(.*?)<\/lastmod>/', $content, $lastModMatches);
                    if (!empty($lastModMatches[1])) {
                        $result['last_modified'] = $lastModMatches[1];
                    }

                    break;
                }
            }

            return $result;
        } catch (\Exception $e) {
            Log::warning("SEO Testing - Sitemap internal test failed", ['error' => $e->getMessage()]);
            return [
                'found' => false,
                'url' => null,
                'sitemap_count' => 0,
                'url_count' => 0,
                'last_modified' => null,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}

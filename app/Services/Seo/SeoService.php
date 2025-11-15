<?php

namespace App\Services\Seo;

use App\Models\Dashboard\AboutUs;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\SeoAssistant;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Helper\Path;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SeoService
{
    /**
     * Get site name from SEO or config
     */
    protected function siteName(): string
    {
        return $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name') ?? 'Site';
    }

    /**
     * Build page title 
     */
    protected function pageTitle($title): string
    {
        return $title;
    }

    /**
     * Get meta description from SEO or fallback
     */
    protected function pageDesc($key, $fallback = ''): string
    {
        return $this->seo?->{$key . '_' . $this->lang} ?? $fallback;
    }
    protected string $lang;
    protected ?Setting $setting;
    protected ?SeoAssistant $seo;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
        $this->setting = Setting::first();
        $this->seo = SeoAssistant::first();
    }

    public function aboutPage(): array
    {
        $about = AboutUs::first();
        $title = $this->pageTitle($this->pageDesc('about_meta_title', $about?->title_en ?? $about?->title_ar ?? 'About Us'));
        $desc = $this->pageDesc('about_meta_desc', strip_tags($this->lang === 'en' ? ($about->text_en ?? '') : ($about->text_ar ?? '')));
        $url = url('/' . $this->lang . '/about-us');
        $image = $about?->image_path ?? asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateArticleSchema($title, $desc, $url, $image, $about);
        return [$schema, $metatags];
    }

    public function homePage(): array
    {
        $title = $this->pageTitle($this->pageDesc('home_meta_title', 'Home'));
        $desc = $this->pageDesc('home_meta_desc', config('configrations.site_description') ?? '');
        $keywords = $this->pageDesc('home_meta_keywords', config('configrations.site_keywords') ?? '');
        $url = url('/' . $this->lang);
        $image = asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image, null, null, null, null, $keywords);
        $schema = $this->generateOrganizationSchema($title, $desc, $url, $image);
        return [$schema, $metatags];
    }

    public function contactPage(): array
    {
        $title = $this->pageTitle($this->pageDesc('contact_meta_title', 'Contact Us'));
        $desc = $this->pageDesc('contact_meta_desc', 'Get in touch with ' . $this->siteName() . '. We are here to help you with all your web and hosting needs.');
        $url = url('/' . $this->lang . '/contact-us');
        $image = asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateLocalBusinessSchema();
        return [$schema, $metatags];
    }

    public function blogsPage(): array
    {
        $title = $this->pageTitle($this->pageDesc('blog_meta_title', 'Blog'));
        $desc = $this->pageDesc('blog_meta_desc', 'Read our latest articles and insights about web development, hosting, and technology.');
        $url = url('/' . $this->lang . '/blogs');
        $image = asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateBlogListSchema($title, $desc, $url, $image);
        return [$schema, $metatags];
    }

    public function servicesPage(): array
    {
        $title = $this->pageTitle($this->pageDesc('service_meta_title', 'Our Services'));
        $desc = $this->pageDesc('service_meta_desc', 'Explore our comprehensive range of web development and hosting services.');
        $url = url('/' . $this->lang . '/services');
        $image = asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateServiceListSchema($title, $desc, $url, $image);
        return [$schema, $metatags];
    }

    public function productsPage(): array
    {
        $title = $this->pageTitle($this->pageDesc('products_meta_title', 'Our Products'));
        $desc = $this->pageDesc('products_meta_desc', 'Discover our innovative products designed to meet your business needs.');
        $url = url('/' . $this->lang . '/products');
        $image = asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateProductListSchema($title, $desc, $url, $image);
        return [$schema, $metatags];
    }

    public function blogDetailsPage($blog): array
    {
        // استخدام meta_title إذا كان موجود، وإلا استخدام الاسم
        $metaTitle = $blog->getTranslation('meta_title', $this->lang);
        $title = !empty($metaTitle) ? $metaTitle : ($blog->name . ' | ' . config('configrations.site_name'));

        // استخدام meta_desc إذا كان موجود، وإلا استخدام short_desc
        $metaDesc = $blog->getTranslation('meta_desc', $this->lang);
        $desc = !empty($metaDesc) ? strip_tags($metaDesc) : strip_tags($blog->short_desc);
        $url = $blog->getLocalizedUrl($this->lang);
        $image = $blog->image_path ?? asset(Path::AppLogo());

        // تنسيق التاريخ الموجود في المقالة
        $formattedTime = $blog->date ? Carbon::parse($blog->date)->format('D M d H:i:s \U\T\C Y') : null;

        $metatags = $this->generateMetaTags(
            $title,
            $desc,
            $url,
            $image,
            $blog->writer_name ?? null,
            $blog->created_at?->toIso8601String(),
            $blog->updated_at?->toIso8601String(),
            $formattedTime // ← نمرره كـ تاريخ المقالة الحقيقي
        );

        $schema = $this->generateBlogPostSchema($blog);

        return [$schema, $metatags];
    }

    public function serviceDetailsPage($service): array
    {
        // استخدام meta_title إذا كان موجود، وإلا استخدام الاسم
        $metaTitle = $service->getTranslation('meta_title', $this->lang);
        $title = !empty($metaTitle) ? $metaTitle : ($service->name . ' | ' . config('configrations.site_name'));

        // استخدام meta_desc إذا كان موجود، وإلا استخدام short_desc
        $metaDesc = $service->getTranslation('meta_desc', $this->lang);
        $desc = !empty($metaDesc) ? strip_tags($metaDesc) : strip_tags($service->short_desc);
        $url = $service->getLocalizedUrl($this->lang);
        $image = $service->image_path ?? asset(Path::AppLogo());



        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateServiceSchema($title, $title  . config('configrations.site_name'), $desc, $url, $image, ['service_type' => $service->name]);

        return [$schema, $metatags];
    }

    public function productDetailsPage($product): array
    {
        // استخدام meta_title إذا كان موجود، وإلا استخدام الاسم
        $metaTitle = $product->getTranslation('meta_title', $this->lang);
        $title = !empty($metaTitle) ? $metaTitle : ($product->name . ' | ' . config('configrations.site_name'));

        // استخدام meta_desc إذا كان موجود، وإلا استخدام short_desc
        $metaDesc = $product->getTranslation('meta_desc', $this->lang);
        $desc = !empty($metaDesc) ? strip_tags($metaDesc) : strip_tags($product->short_desc);
        $url = url('/' . $this->lang . '/products/' . $product->{'slug_' . $this->lang});
        $image = $product->image_path ?? asset(Path::AppLogo());

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);
        $schema = $this->generateProductSchema($title, $title  . config('configrations.site_name'), $desc, $url, $image, ['price' => $product->price ?? '']);

        return [$schema, $metatags];
    }

    public function generateMetaTags(
        string $title,
        string $description,
        string $url,
        string $image,
        ?string $author = null,
        ?string $publishedAt = null,
        ?string $updatedAt = null,
        ?string $formattedTime = null,
        ?string $keywords = null
    ): array {
        $metatags = [
            // Basic Meta Tags
            'charset' => 'utf-8',
            'viewport' => 'width=device-width, initial-scale=1.0',
            'language' => $this->lang,
            'robots' => 'index, follow',
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'author' => $author ?? config('configrations.site_name'),
            'canonical' => $url,

            // Open Graph Tags
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $url,
            'og_image' => $image,
            'og_type' => 'article',
            'og_site_name' => config('configrations.site_name'),
            'og_locale' => $this->lang,

            // Twitter Tags
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image,
            'twitter_site' => '@your_twitter',
            'twitter_creator' => '@your_twitter',

            // Article Tags
            'article_published_time' => $publishedAt,
            'article_modified_time' => $updatedAt,

            // Custom tag
            'time' => $formattedTime, // <meta name="time">
        ];

        return $metatags;
    }





    protected function generateArticleSchema(string $title, string $desc, string $url, string $image, $about): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'image' => $image,
            'url' => $url,
            'author' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'url' => url('/' . $this->lang),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(Path::AppLogo()),
                ],
            ],
            'datePublished' => $about?->created_at,
            'dateModified' => $about?->updated_at,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
        ];
    }

    protected function generateOrganizationSchema(string $title, string $desc, string $url, string $image): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'LocalBusiness', 'MedicalBusiness'],
            'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
            'description' => $desc,
            'url' => $url,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(Path::AppLogo()),
            ],
            'image' => asset(Path::AppLogo()),
            'priceRange' => '$$-$$$',
        ];

        // Add sameAs only if social media URLs exist
        $sameAs = array_values(array_filter([
            config('settings.site_facebook'),
            config('settings.site_twitter'),
            config('settings.site_linkedin'),
            config('settings.site_instagram'),
            config('settings.site_youtube'),
            config('settings.site_tiktok'),
        ], function ($url) {
            return !empty($url) && $url !== '#' && filter_var($url, FILTER_VALIDATE_URL);
        }));

        if (!empty($sameAs)) {
            $schema['sameAs'] = $sameAs;
        }

        // Add contactPoint only if phone exists
        $phone = config('settings.site_phone') ?? config('settings.site_whatsapp');
        if (!empty($phone)) {
            $schema['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => 'customer service',
                'availableLanguage' => ['Arabic', 'English'],
            ];
        }

        // Add all active addresses from SiteAddress model
        $siteAddresses = \App\Models\SiteAddress::where('status', true)->orderBy('order')->get();

        if ($siteAddresses->isNotEmpty()) {
            $locations = [];
            $allPhones = [];

            foreach ($siteAddresses as $siteAddress) {
                if (!empty($siteAddress->address)) {
                    // Create location with Place object (proper schema.org way)
                    $locationSchema = [
                        '@type' => 'Place',
                        'name' => $siteAddress->title ?? null,
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => $siteAddress->address
                        ]
                    ];

                    // Add map link if exists (use map_link instead of map_url for direct Google Maps link)
                    if (!empty($siteAddress->map_link)) {
                        $locationSchema['hasMap'] = $siteAddress->map_link;
                    }

                    $locations[] = $locationSchema;

                    // Collect phone numbers from all addresses
                    if (!empty($siteAddress->phone) && strlen($siteAddress->phone) > 3) {
                        $allPhones[] = $siteAddress->phone;
                    }
                    if (!empty($siteAddress->phone2) && strlen($siteAddress->phone2) > 3) {
                        $allPhones[] = $siteAddress->phone2;
                    }
                }
            }

            // Add locations to schema - if single location, add as object; if multiple, add as array
            if (count($locations) === 1) {
                $schema['location'] = $locations[0];
                // Also add the first location's address directly to Organization
                if (isset($locations[0]['address'])) {
                    $schema['address'] = $locations[0]['address'];
                }
                // Add hasMap to Organization level if exists
                if (isset($locations[0]['hasMap'])) {
                    $schema['hasMap'] = $locations[0]['hasMap'];
                }
            } elseif (count($locations) > 1) {
                $schema['location'] = $locations;
                // For multiple locations, add the first one's address as main address
                if (isset($locations[0]['address'])) {
                    $schema['address'] = $locations[0]['address'];
                }
            }

            // Add all phone numbers if exist
            if (!empty($allPhones)) {
                $schema['telephone'] = array_unique($allPhones);
            }
        }

        // Add areaServed only if exists
        $areaServed = config('settings.site_area_served');
        if (!empty($areaServed)) {
            $schema['areaServed'] = is_array($areaServed) ? $areaServed : explode(',', $areaServed);
        }

        // Add foundingDate only if exists
        $foundingDate = config('settings.site_founding_date');
        if (!empty($foundingDate)) {
            $schema['foundingDate'] = $foundingDate;
        }

        // Add founder only if exists
        $founder = config('settings.site_founder');
        if (!empty($founder)) {
            $schema['founder'] = [
                '@type' => 'Person',
                'name' => $founder
            ];
        }

        return $schema;
    }

    protected function generateContactPageSchema(string $title, string $desc, string $url, string $image): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'url' => $url,
            'image' => $image,
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => config('settings.site_whatsapp'),
                    'contactType' => 'customer service',
                ],
            ],
        ];
    }

    protected function generateBlogListSchema(string $title, string $desc, string $url, string $image): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'url' => $url,
            'image' => $image,
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(Path::AppLogo()),
                ],
            ],
        ];
    }

    protected function generateServiceListSchema(string $title, string $desc, string $url, string $image): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'url' => $url,
            'image' => $image,
            'provider' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
            ],
        ];
    }

    protected function generateProductListSchema(string $title, string $desc, string $url, string $image): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => $title,
            'description' => $desc,
            'url' => $url,
            'image' => $image,
        ];
    }

    public function get(string $page = 'about'): array
    {
        switch ($page) {
            case 'home':
                return $this->homePage();
            case 'contact':
                return $this->contactPage();
            case 'blogs':
                return $this->blogsPage();
            case 'services':
                return $this->servicesPage();
            case 'products':
                return $this->productsPage();
            case 'about':
            default:
                return $this->aboutPage();
        }
    }

    /**
     * Generate SEO for dynamic pages (single products, blogs, services)
     */
    public function generateDynamicSEO(string $type, array $data): array
    {
        $title = $data['title'] ?? '';
        $desc = $data['description'] ?? '';
        $url = $data['url'] ?? '';
        $image = $data['image'] ?? asset(Path::AppLogo());
        $publishedAt = $data['published_at'] ?? null;
        $updatedAt = $data['updated_at'] ?? null;

        $metatags = $this->generateMetaTags($title, $desc, $url, $image);

        // Generate appropriate schema based on type
        $schema = match ($type) {
            'product' => $this->generateProductSchema($title, $title  . config('configrations.site_name'), $desc, $url, $image, $data),
            'service' => $this->generateServiceSchema($title, $title  . config('configrations.site_name'), $desc, $url, $image, $data),
            default => $this->generateArticleSchema($title, $desc, $url, $image, null)
        };

        return [$schema, $metatags];
    }

    protected function generateProductSchema(string $title, string $ogTitle, string $desc, string $url, string $image, array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'image' => $image,
            'url' => $url,
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name')
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $data['price'] ?? '',
                'priceCurrency' => $data['currency'] ?? 'SAR',
                'availability' => $data['availability'] ?? 'https://schema.org/InStock',
                'url' => $url
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => $data['rating'] ?? '5',
                'reviewCount' => $data['review_count'] ?? '1'
            ]
        ];
    }

    protected function generateBlogPostSchema($blog): array
    {
        $title = $blog->name;
        $desc = strip_tags($blog->short_desc);
        $url = $blog->getLocalizedUrl($this->lang);
        $image = $blog->image_path ?? asset(Path::AppLogo());

        // Build base schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
            'headline' => $title,
            'description' => $desc,
            'image' => $image,
            'url' => $url,
            'datePublished' => $blog->created_at?->toIso8601String(),
            'dateModified' => $blog->updated_at?->toIso8601String(),
        ];

        // Add author
        if (!empty($blog->writer_name)) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $blog->writer_name,
            ];
        } else {
            $schema['author'] = [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'url' => url('/' . $this->lang),
            ];
        }

        // Add publisher
        $schema['publisher'] = [
            '@type' => 'Organization',
            'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(Path::AppLogo()),
            ],
        ];

        // Add articleSection (category)
        if ($blog->category) {
            $categoryName = $blog->category->{'name_' . $this->lang} ?? $blog->category->name_ar ?? $blog->category->name_en;
            if ($categoryName) {
                $schema['articleSection'] = $categoryName;
            }
        }

        // Add keywords - generate from title and category
        $keywords = [];
        if ($blog->category) {
            $categoryName = $blog->category->{'name_' . $this->lang} ?? $blog->category->name_ar ?? $blog->category->name_en;
            if ($categoryName) {
                $keywords[] = $categoryName;
            }
        }
        // Add site name as keyword
        $siteName = config('configrations.site_name');
        if ($siteName) {
            $keywords[] = $siteName;
        }

        if (!empty($keywords)) {
            $schema['keywords'] = implode(', ', $keywords);
        }

        // Add wordCount if content is available
        $content = $blog->getTranslation('long_desc', $this->lang);
        if ($content) {
            $wordCount = str_word_count(strip_tags($content));
            if ($wordCount > 0) {
                $schema['wordCount'] = $wordCount;
            }
        }

        // Add locations from SiteAddress model
        $siteAddresses = \App\Models\SiteAddress::where('status', true)->orderBy('order')->get();

        if ($siteAddresses->isNotEmpty()) {
            $locations = [];

            foreach ($siteAddresses as $siteAddress) {
                if (!empty($siteAddress->address)) {
                    $locationSchema = [
                        '@type' => 'Place',
                        'name' => $siteAddress->title ?? null,
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => $siteAddress->address
                        ]
                    ];

                    // Add map link if exists
                    if (!empty($siteAddress->map_link)) {
                        $locationSchema['hasMap'] = $siteAddress->map_link;
                    }

                    $locations[] = $locationSchema;
                }
            }

            // Add locations to schema
            if (count($locations) === 1) {
                $schema['contentLocation'] = $locations[0];
            } elseif (count($locations) > 1) {
                $schema['contentLocation'] = $locations;
            }
        }

        return $schema;
    }

    protected function generateServiceSchema(string $title, string $ogTitle, string $desc, string $url, string $image, array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $title  . config('configrations.site_name'),
            'description' => $desc,
            'url' => $url,
            'image' => $image,
            'provider' => [
                '@type' => 'Organization',
                'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
                'url' => url('/' . $this->lang),
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Egypt'
            ],
            'serviceType' => $data['service_type'] ?? 'Web Development',
        ];
    }

    /**
     * Generate FAQ Schema for pages with FAQs
     */
    public function generateFAQSchema(array $faqs): array
    {
        $faqItems = [];
        foreach ($faqs as $faq) {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems
        ];
    }

    /**
     * Generate Breadcrumb Schema
     */
    public function generateBreadcrumbSchema(array $breadcrumbs): array
    {
        $breadcrumbItems = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url'] ?? null
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems
        ];
    }

    /**
     * Generate LocalBusiness Schema for contact page
     */
    protected function generateLocalBusinessSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $this->seo?->{'home_meta_title_' . $this->lang} ?? config('configrations.site_name'),
            'description' => $this->pageDesc('home_meta_desc', config('configrations.site_description') ?? ''),
            'url' => url('/' . $this->lang),
            'logo' => asset(Path::AppLogo()),
            'image' => asset(Path::AppLogo()),
            'telephone' => config('settings.site_phone'),
            'email' => config('settings.site_email'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('settings.site_address'),
                'addressLocality' => config('settings.site_city'),
                'addressCountry' => config('settings.site_country', 'Egypt')
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => config('settings.site_latitude'),
                'longitude' => config('settings.site_longitude')
            ],
            'openingHours' => [
                'Mo-Fr 09:00-18:00',
                'Sa 09:00-14:00'
            ],
            'sameAs' => array_values(array_filter([
                config('settings.site_facebook'),
                config('settings.site_twitter'),
                config('settings.site_linkedin'),
                config('settings.site_instagram'),
                config('settings.site_youtube'),
                config('settings.site_tiktok'),
            ], function ($url) {
                return !empty($url) && $url !== '#' && filter_var($url, FILTER_VALIDATE_URL);
            })),
            'priceRange' => '$$'
        ];
    }
}
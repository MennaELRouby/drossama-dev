<?php

namespace App\Http\Controllers\Website;

use App\Helper\SocialMediaHelper;
use App\Helper\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\SaveCareerApplicationRequest;
use App\Http\Requests\Website\StoreContactUsRequest;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\Dashboard\AboutStruct;
use App\Models\Dashboard\AboutUs;
use App\Models\Dashboard\Domain;
use App\Models\Faq;
use App\Models\GalleryVideo;
use App\Models\JobPosition;
use App\Models\Phone;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteAddress;
use App\Models\Statistic;
use App\Models\Certificate;
use App\Services\Dashboard\SaveApplicationService;
use App\Services\Website\ContactUsService;
use App\Services\Website\StoreContactUsService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use App\Models\Album;

class WebsiteController extends Controller
{
    public function about()
    {
        $data['about'] = AboutUs::firstOrNew();
        $data['about_structs'] = AboutStruct::active()->get();
        $data['faqs'] = Faq::active()->general()->get();
        $data['statistics'] = Statistic::active()->take(4)->get();
        $data['teams'] = Certificate::active()->orderBy('order')->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.about', $data);
    }

    public function whyUs()
    {
        $data['about_structs'] = AboutStruct::active()->orderBy('order')->get();
        $data['sections'] = \App\Models\Section::where('key', 'whyus')->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.why-us', $data);
    }

    public function services()
    {
        $data['services'] = Service::active()->get();
        $data['sections'] = Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();

        return view('Website.services', $data);
    }

    public function serviceDetails($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded characters and fix mojibake
        $decodedSlug = urldecode($slug);

        // Fix Arabic mojibake encoding issues
        $fixedSlug = StringHelper::fixArabicMojibake($decodedSlug);

        // Try to find service using JSON_EXTRACT for current locale
        $service = Service::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$fixedSlug])->first();

        // If not found, try with original decoded slug
        if (!$service) {
            $service = Service::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();
        }

        // If not found, try to find by checking all services manually (fallback for double JSON issue)
        if (!$service) {
            $services = Service::all();
            foreach ($services as $s) {
                $serviceSlug = $s->getTranslation('slug', $locale);
                if ($serviceSlug === $fixedSlug || $serviceSlug === $decodedSlug) {
                    $service = $s;
                    break;
                }
            }
        }

        // If still not found, try to find by checking all languages
        if (!$service) {
            $services = Service::all();
            foreach ($services as $s) {
                foreach (['en', 'ar', 'fr'] as $lang) {
                    $serviceSlug = $s->getTranslation('slug', $lang);
                    if ($serviceSlug === $fixedSlug || $serviceSlug === $decodedSlug) {
                        $service = $s;
                        break 2;
                    }
                }
            }
        }

        if (!$service) {
            abort(404);
        }

        // The middleware will handle slug redirections, so we just display the service

        // #call# placeholder will be replaced automatically by the model accessor
        $socialMediaLinks = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.service-details', compact('service', 'socialMediaLinks'));
    }

    public function categories()
    {
        $data['categories'] = Category::active()->get();
        $data['services'] = Service::active()->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.categories', $data);
    }

    public function categoryDetails($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded Arabic characters
        $decodedSlug = urldecode($slug);

        // Try to find category using JSON_EXTRACT for current locale
        $category = Category::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();

        // If not found, try to find by checking all categories manually (fallback for double JSON issue)
        if (!$category) {
            $categories = Category::all();
            foreach ($categories as $c) {
                $categorySlug = $c->getTranslation('slug', $locale);
                if ($categorySlug === $decodedSlug) {
                    $category = $c;
                    break;
                }
            }
        }

        // If still not found, try to find by checking all languages
        if (!$category) {
            $categories = Category::all();
            foreach ($categories as $c) {
                foreach (['en', 'ar', 'fr'] as $lang) {
                    $categorySlug = $c->getTranslation('slug', $lang);
                    if ($categorySlug === $decodedSlug) {
                        $category = $c;
                        break 2;
                    }
                }
            }
        }

        if (!$category) {
            abort(404);
        }

        // #call# placeholder will be replaced automatically by the model accessor
        $socialMediaLinks = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.category-details', compact('category', 'socialMediaLinks'));
    }

    public function showContactUs()
    {
        $data['site_addresses'] = SiteAddress::active()->orderBy('order')->get();
        $data['phones'] = Phone::active()->orderBy('order')->get();

        // Get sections
        $sections = Section::all();

        $data['sections'] = $sections;
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.contact-us', $data);
    }

    public function saveContactUs(StoreContactUsRequest $request)
    {
        try {

            $data = $request->validated();

            $response = (new ContactUsService)->store($data);

            if (!$response) {
                return redirect()->back()->with(['error' => __('website.failed_to_send_message')]);
            }

            return redirect()->route('website.thank-you');
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('website.something wrong pls try letter')]);
        }
    }

    public function thankYou()
    {
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.thank-you', $data);
    }

    public function products()
    {
        $data['products'] = Product::active()->whereNull('parent_id')->get();
        $data['sections'] = Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();

        return view('Website.products', $data);
    }

    public function productSubProducts($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded Arabic characters
        $decodedSlug = urldecode($slug);

        // Try to find product using JSON_EXTRACT
        $product = Product::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();

        // If not found, try to find by checking all products manually
        if (!$product) {
            $products = Product::all();
            foreach ($products as $p) {
                $productSlug = $p->getTranslation('slug', $locale);
                if ($productSlug === $decodedSlug) {
                    $product = $p;
                    break;
                }
            }
        }

        if (!$product) {
            abort(404);
        }

        // Get sub products (children)
        $data['subProducts'] = $product->children()->where('status', 1)->get();
        $data['parentProduct'] = $product;
        $data['sections'] = Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();

        return view('Website.product-sub-products', $data);
    }

    public function productDetails($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded Arabic characters
        $decodedSlug = urldecode($slug);

        // Try to find product using JSON_EXTRACT
        $product = Product::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();

        // If not found, try to find by checking all products manually (fallback for double JSON issue)
        if (!$product) {
            $products = Product::all();
            foreach ($products as $p) {
                $productSlug = $p->getTranslation('slug', $locale);
                if ($productSlug === $decodedSlug) {
                    $product = $p;
                    break;
                }
            }
        }

        if (!$product) {
            abort(404);
        }

        // #call# placeholder will be replaced automatically by the model accessor
        $socialMediaLinks = SocialMediaHelper::getSocialMediaLinks();
        // Get only partners associated with this product
        $brands = $product->parteners()->where('parteners.status', 1)->orderBy('parteners.order')->get();
        $sections = Section::all();

        return view('Website.product-details', compact('product', 'socialMediaLinks', 'brands', 'sections'));
    }

    public function projects()
    {
        $data['projects'] = Project::active()->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.projects', $data);
    }
    public function projectDetails($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded Arabic characters
        $decodedSlug = urldecode($slug);

        // Try to find project using JSON_EXTRACT
        $project = Project::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();

        // If not found, try to find by checking all projects manually (fallback for double JSON issue)
        if (!$project) {
            $projects = Project::all();
            foreach ($projects as $p) {
                $projectSlug = $p->getTranslation('slug', $locale);
                if ($projectSlug === $decodedSlug) {
                    $project = $p;
                    break;
                }
            }
        }

        if (!$project) {
            abort(404);
        }

        // #call# placeholder will be replaced automatically by the model accessor
        $socialMediaLinks = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.project-details', compact('project', 'socialMediaLinks'));
    }

    public function blogs()
    {
        $data['blogs'] = Blog::active()->orderBy('created_at', 'desc')->paginate(9);
        $data['sections'] = \App\Models\Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.blogs', $data);
    }
    public function blogDetails($slug)
    {
        $locale = app()->getLocale();

        // Decode URL-encoded Arabic characters
        $decodedSlug = urldecode($slug);

        // Try to find blog using JSON_EXTRACT for current locale
        $blog = Blog::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$decodedSlug])->first();

        // If not found, try to find by checking all blogs manually (fallback for double JSON issue)
        if (!$blog) {
            $blogs = Blog::all();
            foreach ($blogs as $b) {
                $blogSlug = $b->getTranslation('slug', $locale);
                if ($blogSlug === $decodedSlug) {
                    $blog = $b;
                    break;
                }
            }
        }

        // If still not found, try to find by checking all languages
        if (!$blog) {
            $blogs = Blog::all();
            foreach ($blogs as $b) {
                foreach (['en', 'ar', 'fr'] as $lang) {
                    $blogSlug = $b->getTranslation('slug', $lang);
                    if ($blogSlug === $decodedSlug) {
                        $blog = $b;
                        break 2;
                    }
                }
            }
        }

        if (!$blog) {
            abort(404);
        }

        // #call# placeholder will be replaced automatically by the model accessor

        // Get related blogs (excluding current blog)
        $blogs = Blog::active()->where('id', '!=', $blog->id)->limit(5)->get();
        $socialMediaLinks = SocialMediaHelper::getSocialMediaLinks();

        return view('Website.blog-details', compact('blog', 'blogs', 'socialMediaLinks'));
    }

    public function careers()
    {
        $data['gallery_videos'] = GalleryVideo::active()->get();
        $data['job_positions'] = JobPosition::active()->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.careers', $data);
    }

    public function saveApplication(SaveCareerApplicationRequest $request)
    {
        try {

            $response = (new SaveApplicationService)->saveApplication($request);

            if (!$response) {
                return redirect()->back()->with(['error' => __('website.failed_to_send_message')]);
            }

            return redirect()->back()->with(['success' => __('website.thanks_message')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('website.something wrong pls try letter')]);
        }
    }

    public function galleryPhotos()
    {
        $data['gallery_photos'] = Album::active()->with('images')->get();
        $data['sections'] = \App\Models\Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.gallery-photos', $data);
    }

    public function galleryVideos()
    {
        $data['gallery_videos'] = GalleryVideo::active()->get();
        $data['sections'] = \App\Models\Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.gallery-videos', $data);
    }

    public function faqs()
    {
        $data['faqs'] = \App\Models\Faq::active()->orderBy('order')->get();
        $data['sections'] = \App\Models\Section::all();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        return view('Website.faqs', $data);
    }
}

<?php

namespace App\Http\Controllers\Website;

use App\Helper\SocialMediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\Client;
use App\Models\Dashboard\AboutStruct;
use App\Models\Dashboard\AboutUs;
use App\Models\Dashboard\Domain;
use App\Models\Dashboard\Hosting;
use App\Models\Dashboard\Plan;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Section;
use App\Models\Testimonial;
use App\Models\SiteAddress;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Partener;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $currentLanguage = app()->getLocale();
        $data['banner'] = Slider::home()->active()->forLanguage($currentLanguage)->orderBy('order')->first();
        $data['sliders'] = Slider::home()->active()->forLanguage($currentLanguage)->orderBy('order')->get();
        $data['about'] = AboutUs::firstOrNew();
        $data['about_structs'] = AboutStruct::active()->orderBy('order')->get();
        $data['products'] = Product::active()->whereNull('parent_id')->home()->orderBy('order')->take(9)->get();
        $data['projects'] = Project::active()->home()->orderBy('order')->take(4)->get();
        $data['benefits'] = Benefit::active()->orderBy('order')->general()->take(4)->get();
        $data['services'] = Service::active()->home()->orderBy('order')->take(3)->get();
        $data['testimonials'] = Testimonial::active()->get();
        $data['blogs'] = Blog::active()->home()->orderBy('order')->take(3)->get();
        $data['clients'] = Client::active()->orderBy('order')->take(6)->get();
        $data['faqs'] = Faq::active()->general()->orderBy('order')->take(5)->get();
        $data['Benefits'] = Benefit::active()->orderBy('order')->general()->take(4)->get();
        $data['categories'] = Category::with('products')->active()->home()->orderBy('order')->take(4)->get();
        $data['site_addresses'] = SiteAddress::active()->orderBy('order')->get();
        $data['products_section'] = Section::where('key', 'products')->get();
        $data['testimonial_section'] = Section::where('key', 'testimonial')->get();
        $data['blogs_section'] = Section::where('key', 'blogs')->get();
        $data['about_structs'] = AboutStruct::active()->orderBy('order')->get();
        // Get all sections and organize by key
        $allSections = Section::where('status', 1)->get();
        $data['sections'] = $allSections->keyBy('key');
        $data['phones'] = Phone::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();
        $data['socialMediaLinks'] = SocialMediaHelper::getSocialMediaLinks();
        $data['albums'] = Album::active()->orderBy('order')->get();
        $data['brands'] = Partener::active()->orderBy('order')->get();


        return view('Website.home', $data);
    }
}

<?php

namespace App\Services\Dashboard;

use App\Models\Admin;
use App\Models\Author;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CareerApplication;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\Dashboard\AboutStruct;
use App\Models\Dashboard\Domain;
use App\Models\Dashboard\Hosting;
use App\Models\Dashboard\Menu;
use App\Models\Dashboard\Plan;
use App\Models\Slider;
use App\Models\Faq;
use App\Models\GalleryVideo;
use App\Models\JobPosition;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteAddress;
use App\Models\Statistic;
use App\Models\Subscribe;
use App\Models\Testimonial;
use App\Models\User;

class DashboardService
{

    public function countModels()
    {
        $statisticsCount = Statistic::count();
        $contactUsCount = ContactUs::count();
        $subscribersCount = Subscribe::count();
        $menusCount = Menu::count();
        $slidersCount = Slider::count();
        $faqsCount = Faq::count();
        $testimonialsCount = Testimonial::count();
        $galleryVideosCount = GalleryVideo::count();
        $benefitsCount = Benefit::count();
        $aboutStructsCount = AboutStruct::count();
        $servicesCount = Service::count();
        $productsCount = Product::count();
        $plansCount = Plan::count();
        $hostingsCount = Hosting::count();
        $domainsCount = Domain::count();
        $blogCategoriesCount = BlogCategory::count();
        $authorCount = Author::count();
        $blogsCount = Blog::count();
        $jobPositionsCount = JobPosition::count();
        $applicationsCount = CareerApplication::count();
        $clientsCount = Client::count();
        $siteAddressesCount = SiteAddress::count();
        $adminsCount = Admin::count();
        $usersCount = User::count();

        return [

            'statistics' => $statisticsCount,
            'contact_messages' => $contactUsCount,
            'subscribers' => $subscribersCount,
            'menus' => $menusCount,
            'sliders' => $slidersCount,
            'faqs' => $faqsCount,
            'testimonials' => $testimonialsCount,
            'gallery_videos' => $galleryVideosCount,
            'benefits' => $benefitsCount,
            'about_structs' => $aboutStructsCount,
            'services' => $servicesCount,
            'products' => $productsCount,
            'plans' => $plansCount,
            'domains' => $domainsCount,
            'hosting' => $hostingsCount,
            'blog_categories' => $blogCategoriesCount,
            'authors' => $authorCount,
            'blogs' => $blogsCount,
            'job_positions' => $jobPositionsCount,
            'career_applications' => $applicationsCount,
            'clients' => $clientsCount,
            'site_addresses' => $siteAddressesCount,
            'admins' => $adminsCount,
            'users' => $usersCount,
        ];
    }

    public function changeStatus($model, $ids)
    {
        foreach ($ids as $id) {
            if ($model == 'hostings') {

                $updatedModel = Hosting::find($id);
            }
            if ($model == 'menus') {

                $updatedModel = Menu::find($id);
            }
            if ($model == 'sliders') {

                $updatedModel = Slider::find($id);
            }
            if ($model == 'domains') {

                $updatedModel = Domain::find($id);
            }
            if ($model == 'Benefits') {

                $updatedModel = Benefit::find($id);
            }
            if ($model == 'about-structs') {

                $updatedModel = AboutStruct::find($id);
            }
            if ($model == 'products') {

                $updatedModel = Product::find($id);
            }
            if ($model == 'blog-categories') {

                $updatedModel = BlogCategory::find($id);
            }
            if ($model == 'blogs') {

                $updatedModel = Blog::find($id);
            }
            if ($model == 'clients') {

                $updatedModel = Client::find($id);
            }
            if ($model == 'site-addresses') {

                $updatedModel = SiteAddress::find($id);
            }
            if ($model == 'statistics') {

                $updatedModel = Statistic::find($id);
            }
            if ($model == 'gallery_videos') {

                $updatedModel = GalleryVideo::find($id);
            }
            if ($model == 'job_positions') {

                $updatedModel = JobPosition::find($id);
            }
            if ($model == 'faqs') {

                $updatedModel = Faq::find($id);
            }
            if ($model == 'testimonials') {

                $updatedModel = Testimonial::find($id);
            }
            if ($model == 'services') {

                $updatedModel = Service::find($id);
            }


            if ($model == 'pages') {

                $updatedModel = Page::find($id);
            }
            if ($updatedModel) {

                $newStatus = $updatedModel->status == 1 ? 0 : 1;
                $updatedModel->update(['status' => $newStatus]);
            }
        }
        return true;
    }
}

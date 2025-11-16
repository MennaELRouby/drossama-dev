<?php

use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\WebsiteController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// These routes are already wrapped with localization middleware and prefix in bootstrap/app.php
// Do NOT use '/' or '' as route path when inside a prefix group - it won't work as expected
// Instead, we'll handle the localized root in a separate way

// Note: manifest.json route is defined in routes/web.php (outside localization group)
Route::get('about-us', [WebsiteController::class, 'about'])->name('about-us');
Route::get('why-us', [WebsiteController::class, 'whyUs'])->name('why-us');
Route::get('services', [WebsiteController::class, 'services'])->name('services');
Route::get('services/{slug}', [WebsiteController::class, 'serviceDetails'])->name('serviceDetails');
Route::get('contact-us', [WebsiteController::class, 'showContactUs'])->name('contact-us');
Route::post('save-contact-us', [WebsiteController::class, 'saveContactUs'])->name('saveConatct')->middleware('throttle:2');
Route::get('thank-you', [WebsiteController::class, 'thankYou'])->name('thank-you');
Route::get('faqs', [WebsiteController::class, 'faqs'])->name('faqs');
Route::get('products', [WebsiteController::class, 'products'])->name('products');
Route::get('products/{slug}/sub-products', [WebsiteController::class, 'productSubProducts'])->name('productSubProducts');
Route::get('products/{product}', [WebsiteController::class, 'productDetails'])->name('productDetails');
Route::get('projects', [WebsiteController::class, 'projects'])->name('projects');
Route::get('projects/{project}', [WebsiteController::class, 'projectDetails'])->name('projectDetails');
Route::get('categories', [WebsiteController::class, 'categories'])->name('categories');
Route::get('categories/{slug}', [WebsiteController::class, 'categoryDetails'])->name('categoryDetails');
Route::get('blogs', [WebsiteController::class, 'blogs'])->name('blogs');
Route::get('blog/{slug}', [WebsiteController::class, 'blogDetails'])->name('blogDetails');
Route::get('careers', [WebsiteController::class, 'careers'])->name('careers');
Route::post('save-application', [WebsiteController::class, 'saveApplication'])->name('saveApplication');
Route::get('gallery-photos', [WebsiteController::class, 'galleryPhotos'])->name('galleryPhotos');
Route::get('gallery-videos', [WebsiteController::class, 'galleryVideos'])->name('galleryVideos');
Route::get('testimonials', [WebsiteController::class, 'testimonials'])->name('testimonials');

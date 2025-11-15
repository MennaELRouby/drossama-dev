<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AIContentController;
use App\Http\Controllers\Dashboard\TinyMCEController;
use App\Http\Controllers\Dashboard\SeoTestingController;
use App\Http\Controllers\Dashboard\SeoAIController;
use App\Http\Controllers\Dashboard\RedirectController;

Route::group(['controller' => \App\Http\Controllers\Dashboard\DashboardController::class, 'middleware' => ['secure.headers']], function () {
    Route::get('/', 'index')->name('home');
    Route::post('{modelname}/change-status/{ids}', 'changeStatus')->name('change.status');
});


Route::group(['prefix' => 'settings', 'controller' => \App\Http\Controllers\Dashboard\SettingController::class, 'as' => 'settings.'], function () {
    Route::get('/', 'show')->name('show');
    Route::patch('/', 'update')->name('update');
});

// Email Test Routes
Route::group(['prefix' => 'email-test', 'controller' => \App\Http\Controllers\Dashboard\EmailTestController::class, 'as' => 'email-test.'], function () {
    Route::get('/', 'index')->name('index');
    Route::post('/send', 'send')->name('send');
});

// PWA Settings Routes
Route::group(['prefix' => 'pwa-settings', 'controller' => \App\Http\Controllers\Dashboard\PwaSettingController::class, 'as' => 'pwa-settings.'], function () {
    Route::get('/', 'index')->name('index');
    Route::get('{pwaSetting}/edit', 'edit')->name('edit');
    Route::patch('{pwaSetting}', 'update')->name('update');
    Route::post('/regenerate-icons', 'regenerateIcons')->name('regenerate-icons');
});

Route::group(['prefix' => 'configrations', 'controller' => \App\Http\Controllers\Dashboard\ConfigrationController::class, 'as' => 'configrations.'], function () {
    Route::get('{lang}', 'edit')->name('edit');
    Route::patch('{lang}', 'update')->name('update');
});

Route::group(['prefix' => 'career_applications', 'controller' => \App\Http\Controllers\Dashboard\CareerApplicationController::class, 'as' => 'career_applications.'], function () {
    Route::get('download-cv/{application}', 'downloadCV')->name('download.cv');
    Route::get('show/{application}', 'show')->name('show');
    Route::get('/', 'index')->name('index');
    Route::delete('{application}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'contact_messages', 'controller' => \App\Http\Controllers\Dashboard\ContactMessageController::class, 'as' => 'contact_messages.'], function () {
    Route::get('/', 'index')->name('index');
    Route::get('show/{message}', 'show')->name('show');
    Route::delete('{message}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'about-us', 'controller' =>  \App\Http\Controllers\Dashboard\AboutUsController::class, 'as' => 'about.'], function () {
    Route::get('/', 'edit')->name('edit');
    Route::patch('{about}', 'update')->name('update');
});

Route::resource('hostings', \App\Http\Controllers\Dashboard\HostingController::class);
Route::resource('hostings.benefits', \App\Http\Controllers\Dashboard\HostingBenefitController::class);
Route::resource('hostings.faqs', \App\Http\Controllers\Dashboard\HostingFaqController::class);
Route::resource('attributes', \App\Http\Controllers\Dashboard\AttributeController::class);
Route::resource('attributes.values', \App\Http\Controllers\Dashboard\AttributeValueController::class);
Route::resource('plans', \App\Http\Controllers\Dashboard\PlanController::class);
Route::get('plans/{plan}/attributes-values', [\App\Http\Controllers\Dashboard\PlanController::class, 'createPlanAttributeValues'])->name('plan.createAttributeValues');
Route::post('plans/{plan}/attributes-values', [\App\Http\Controllers\Dashboard\PlanController::class, 'storeAttributeValues'])->name('plans.storeAttributeValues');
Route::delete('menus/bulk', [\App\Http\Controllers\Dashboard\MenuController::class, 'bulkDestroy'])->name('menus.bulk.destroy');
Route::patch('menus/{menu}/toggle-status', [\App\Http\Controllers\Dashboard\MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
Route::resource('menus', \App\Http\Controllers\Dashboard\MenuController::class);
Route::delete('sliders/bulk', [\App\Http\Controllers\Dashboard\SliderController::class, 'bulkDestroy'])->name('sliders.bulk.destroy');
Route::patch('sliders/{slider}/toggle-status', [\App\Http\Controllers\Dashboard\SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
Route::resource('sliders', \App\Http\Controllers\Dashboard\SliderController::class);
Route::resource('domains', \App\Http\Controllers\Dashboard\DomainController::class);
Route::resource('about-structs', \App\Http\Controllers\Dashboard\AboutStructController::class);
Route::patch('about-structs/{about_struct}/toggle-status', [\App\Http\Controllers\Dashboard\AboutStructController::class, 'toggleStatus'])->name('about-structs.toggle-status');
Route::resource('roles', \App\Http\Controllers\Dashboard\RoleController::class);
Route::resource('admins', \App\Http\Controllers\Dashboard\AdminController::class);
Route::resource('faqs', \App\Http\Controllers\Dashboard\FaqController::class);
Route::delete('faqs/bulk', [\App\Http\Controllers\Dashboard\FaqController::class, 'bulkDestroy'])->name('faqs.bulk.destroy');
Route::resource('benefits', \App\Http\Controllers\Dashboard\BenefitController::class);
Route::resource('testimonials', \App\Http\Controllers\Dashboard\TestimonialController::class);
Route::resource('certificates', \App\Http\Controllers\Dashboard\CertificateController::class);
Route::delete('services/bulk', [\App\Http\Controllers\Dashboard\ServiceController::class, 'bulkDestroy'])->name('services.bulk.destroy');
Route::patch('services/{service}/toggle-status', [\App\Http\Controllers\Dashboard\ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
Route::resource('services', \App\Http\Controllers\Dashboard\ServiceController::class);
Route::resource('site-addresses', \App\Http\Controllers\Dashboard\SiteAddressController::class);
Route::delete('site-addresses/bulk', [\App\Http\Controllers\Dashboard\SiteAddressController::class, 'bulkDestroy'])->name('site-addresses.bulk.destroy');
Route::delete('products/bulk', [\App\Http\Controllers\Dashboard\ProductController::class, 'bulkDestroy'])->name('products.bulk.destroy');
Route::patch('products/{product}/toggle-status', [\App\Http\Controllers\Dashboard\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
Route::resource('products', \App\Http\Controllers\Dashboard\ProductController::class);
Route::post('products/changeCategory/{id}', [\App\Http\Controllers\Dashboard\ProductController::class, 'changeCategory'])->name('products.changeCategory');
Route::post('products/uploadImages', [\App\Http\Controllers\Dashboard\ProductController::class, 'uploadImages'])->name('products.uploadImages');
Route::post('products/removeUploadImages', [\App\Http\Controllers\Dashboard\ProductController::class, 'removeUploadImages'])->name('products.removeUploadImages');
Route::post('products/deleteImage', [\App\Http\Controllers\Dashboard\ProductController::class, 'deleteImage'])->name('products.deleteImage');
Route::post('products/deleteAllImages', [\App\Http\Controllers\Dashboard\ProductController::class, 'deleteAllImages'])->name('products.deleteAllImages');
Route::post('products/deleteSelectedImages', [\App\Http\Controllers\Dashboard\ProductController::class, 'deleteSelectedImages'])->name('products.deleteSelectedImages');
Route::post('products/reorderImages', [\App\Http\Controllers\Dashboard\ProductController::class, 'reorderImages'])->name('products.reorderImages');
Route::delete('projects/bulk', [\App\Http\Controllers\Dashboard\ProjectController::class, 'bulkDestroy'])->name('projects.bulk.destroy');
Route::patch('projects/{project}/toggle-status', [\App\Http\Controllers\Dashboard\ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
Route::resource('projects', \App\Http\Controllers\Dashboard\ProjectController::class);
Route::post('projects/changeCategory/{id}', [\App\Http\Controllers\Dashboard\ProjectController::class, 'changeCategory'])->name('projects.changeCategory');
Route::delete('sections/bulk', [\App\Http\Controllers\Dashboard\SectionController::class, 'bulkDestroy'])->name('sections.bulk.destroy');
Route::patch('sections/{section}/toggle-status', [\App\Http\Controllers\Dashboard\SectionController::class, 'toggleStatus'])->name('sections.toggle-status');
Route::resource('sections', \App\Http\Controllers\Dashboard\SectionController::class);
Route::resource('blog_categories', \App\Http\Controllers\Dashboard\BlogCategoryController::class);
Route::resource('authors', \App\Http\Controllers\Dashboard\AuthorController::class);
Route::delete('blogs/bulk', [\App\Http\Controllers\Dashboard\BlogController::class, 'bulkDestroy'])->name('blogs.bulk.destroy');
Route::patch('blogs/{blog}/toggle-status', [\App\Http\Controllers\Dashboard\BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');
Route::resource('blogs', \App\Http\Controllers\Dashboard\BlogController::class);
Route::resource('clients', \App\Http\Controllers\Dashboard\ClientController::class);
Route::resource('parteners', \App\Http\Controllers\Dashboard\PartenerController::class);
Route::resource('statistics', \App\Http\Controllers\Dashboard\StatisticController::class);
Route::resource('gallery_videos', \App\Http\Controllers\Dashboard\GalleryVideoController::class);
Route::resource('job_positions', \App\Http\Controllers\Dashboard\JobPositionController::class);
Route::resource('subscribers', \App\Http\Controllers\Dashboard\SubscriberController::class)->only(['index', 'destroy']);
Route::resource('pages', \App\Http\Controllers\Dashboard\PageController::class);
Route::resource('phones', \App\Http\Controllers\Dashboard\PhoneController::class);
Route::delete('phones/bulk', [\App\Http\Controllers\Dashboard\PhoneController::class, 'bulkDestroy'])->name('phones.bulk.destroy');
Route::delete('services/image/{id}', [\App\Http\Controllers\Dashboard\ServiceController::class, 'destroyImage'])->name('services.destroyImage');
Route::post('services/uploadImages', [\App\Http\Controllers\Dashboard\ServiceController::class, 'uploadImages'])->name('services.uploadImages');
Route::post('services/removeUploadImages', [\App\Http\Controllers\Dashboard\ServiceController::class, 'removeUploadImages'])->name('services.removeUploadImages');
Route::post('services/deleteImage', [\App\Http\Controllers\Dashboard\ServiceController::class, 'deleteImage'])->name('services.deleteImage');
Route::delete('projects/image/{id}', [\App\Http\Controllers\Dashboard\ProjectController::class, 'destroyImage'])->name('projects.destroyImage');
Route::post('projects/uploadImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'uploadImages'])->name('projects.uploadImages');
Route::post('projects/removeUploadImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'removeUploadImages'])->name('projects.removeUploadImages');
Route::post('projects/deleteImage', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteImage'])->name('projects.deleteImage');
Route::post('projects/deleteAllImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteAllImages'])->name('projects.deleteAllImages');
Route::post('projects/deleteSelectedImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteSelectedImages'])->name('projects.deleteSelectedImages');
Route::post('projects/reorderImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'reorderImages'])->name('projects.reorderImages');
Route::get('scan', [\App\Http\Controllers\Dashboard\ScanController::class, 'scan'])->name('scan.scan');
Route::post('scan/delete-line', [\App\Http\Controllers\Dashboard\ScanController::class, 'deleteLine'])->name('scan.deleteLine');
Route::post('services/deleteAllImages', [\App\Http\Controllers\Dashboard\ServiceController::class, 'deleteAllImages'])->name('services.deleteAllImages');
Route::post('services/deleteSelectedImages', [\App\Http\Controllers\Dashboard\ServiceController::class, 'deleteSelectedImages'])->name('services.deleteSelectedImages');
Route::post('services/reorderImages', [\App\Http\Controllers\Dashboard\ServiceController::class, 'reorderImages'])->name('services.reorderImages');

// Project Images Routes (duplicate - can be removed if routes above are correct)
Route::delete('projects/image/{id}', [\App\Http\Controllers\Dashboard\ProjectController::class, 'destroyImage'])->name('projects.destroyImage');
Route::post('projects/uploadImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'uploadImages'])->name('projects.uploadImages');
Route::post('projects/removeUploadImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'removeUploadImages'])->name('projects.removeUploadImages');
Route::post('projects/deleteImage', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteImage'])->name('projects.deleteImage');
Route::post('projects/deleteAllImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteAllImages'])->name('projects.deleteAllImages');
Route::post('projects/deleteSelectedImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteSelectedImages'])->name('projects.deleteSelectedImages');
Route::post('projects/reorderImages', [\App\Http\Controllers\Dashboard\ProjectController::class, 'reorderImages'])->name('projects.reorderImages');

// SEO Assistant Routes
Route::group(['prefix' => 'seo-assistants', 'controller' => \App\Http\Controllers\Dashboard\SeoAssistantController::class, 'as' => 'seo-assistants.'], function () {
    Route::get('/', 'index')->name('index');
    Route::get('edit', 'edit')->name('edit');
    Route::patch('update', 'update')->name('update');
});

Route::resource('categories', \App\Http\Controllers\Dashboard\CategoryController::class);
Route::post('categories/upload-images', [\App\Http\Controllers\Dashboard\CategoryController::class, 'uploadImages'])->name('categories.uploadImages');
Route::post('categories/remove-upload-images', [\App\Http\Controllers\Dashboard\CategoryController::class, 'removeUploadImages'])->name('categories.removeUploadImages');
Route::post('categories/deleteImage', [\App\Http\Controllers\Dashboard\CategoryController::class, 'deleteImage'])->name('categories.deleteImage');
Route::resource('albums', \App\Http\Controllers\Dashboard\AlbumController::class);
Route::post('albums/uploadImages', [\App\Http\Controllers\Dashboard\AlbumController::class, 'uploadImages'])->name('albums.uploadImages');
Route::post('albums/removeUploadImages', [\App\Http\Controllers\Dashboard\AlbumController::class, 'removeUploadImages'])->name('albums.removeUploadImages');
Route::post('albums/deleteImage', [\App\Http\Controllers\Dashboard\AlbumController::class, 'deleteImage'])->name('albums.deleteImage');
Route::post('albums/deleteAllImages', [\App\Http\Controllers\Dashboard\AlbumController::class, 'deleteAllImages'])->name('albums.deleteAllImages');
Route::post('albums/deleteSelectedImages', [\App\Http\Controllers\Dashboard\AlbumController::class, 'deleteSelectedImages'])->name('albums.deleteSelectedImages');
Route::post('albums/reorderImages', [\App\Http\Controllers\Dashboard\AlbumController::class, 'reorderImages'])->name('albums.reorderImages');
Route::post('albums/changeAlbum/{id}', [\App\Http\Controllers\Dashboard\AlbumController::class, 'changeAlbum'])->name('albums.changeAlbum');
Route::get('/generate-sitemap', [\App\Http\Controllers\SitemapController::class, 'generate'])->name('generate-sitemap');

// TinyMCE Image Upload
Route::post('/tinymce/upload-image', [TinyMCEController::class, 'uploadImage'])->name('tinymce.upload-image');

// AI Content Routes
Route::group(['prefix' => 'ai-content', 'as' => 'ai-content.'], function () {
    Route::get('/', [AIContentController::class, 'index'])->name('index');
    Route::get('/create', [AIContentController::class, 'create'])->name('create');
    Route::post('/generate', [AIContentController::class, 'generate'])->name('generate');
    Route::post('/upload-image', [AIContentController::class, 'uploadImage'])->name('upload-image');
    Route::post('/save-image-to-service', [AIContentController::class, 'saveImageToService'])->name('save-image-to-service');
    Route::post('/save-image-to-blog', [AIContentController::class, 'saveImageToBlog'])->name('save-image-to-blog');
    Route::post('/test-image', function (Illuminate\Http\Request $request) {
        return response()->json([
            'success' => false,
            'error' => 'خدمات توليد الصور غير متاحة. يرجى إضافة API key',
            'enhanced_prompt' => 'Test enhanced prompt',
            'suggestion' => 'يمكنك استخدام الوصف المُحسن أدناه مع أي خدمة توليد صور أخرى',
            'details' => [
                'stability_error' => 'API key not configured',
                'openai_error' => 'API key not configured'
            ]
        ]);
    })->name('test-image');
    Route::get('/stats', [AIContentController::class, 'stats'])->name('stats');
    Route::get('/validate-api', [AIContentController::class, 'validateApi'])->name('validate-api');
    Route::get('/usage-info', [AIContentController::class, 'usageInfo'])->name('usage-info');
    Route::get('/{content}', [AIContentController::class, 'show'])->name('show');
    Route::put('/{content}/status', [AIContentController::class, 'updateStatus'])->name('update-status');
    Route::delete('/{content}', [AIContentController::class, 'destroy'])->name('destroy');
    Route::post('/{content}/apply', [AIContentController::class, 'applyToModel'])->name('apply-to-model');
});

// SEO Routes
Route::group(['prefix' => 'seo', 'as' => 'seo.', 'middleware' => ['web', 'auth:admin']], function () {
    // SEO Testing
    Route::get('testing', [SeoTestingController::class, 'index'])->name('testing');
    Route::post('testing/comprehensive', [SeoTestingController::class, 'runComprehensiveTest'])->name('testing.comprehensive');
    Route::post('testing/quick', [SeoTestingController::class, 'runQuickTest'])->name('testing.quick');
    Route::get('testing/sitemap', [SeoTestingController::class, 'testSitemap'])->name('testing.sitemap');
    Route::get('testing/recommendations', [SeoTestingController::class, 'getRecommendations'])->name('testing.recommendations');
    Route::post('testing/dynamic-page', [SeoTestingController::class, 'testDynamicPage'])->name('testing.dynamic-page');
    Route::get('testing/dynamic-pages-status', [SeoTestingController::class, 'checkDynamicPagesStatus'])->name('testing.dynamic-pages-status');

    // SEO AI Generation
    Route::post('generate', [SeoAIController::class, 'generateSEO'])->name('generate');
    Route::post('generate-field', [SeoAIController::class, 'generateField'])->name('generate-field');
});

// Redirects Management
Route::resource('redirects', RedirectController::class)->names('redirects');
Route::get('redirects-import', [RedirectController::class, 'importForm'])->name('redirects.import-form');
Route::post('redirects-import', [RedirectController::class, 'import'])->name('redirects.import');
Route::get('redirects-template', [RedirectController::class, 'downloadTemplate'])->name('redirects.template');

// Performance Monitoring
Route::group(['prefix' => 'performance', 'as' => 'performance.', 'controller' => \App\Http\Controllers\Dashboard\PerformanceController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
});

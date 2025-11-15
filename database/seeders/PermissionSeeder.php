<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $groupedPermissions = [
            'dashboard' => ['dashboard.view'],

            'admins' => [
                'admins.view',
                'admins.create',
                'admins.store',
                'admins.edit',
                'admins.update',
                'admins.delete',
            ],
            'users' => [
                'users.view',
                'users.create',
                'users.store',
                'users.edit',
                'users.update',
                'users.delete',
            ],
            'roles' => [
                'roles.view',
                'roles.create',
                'roles.store',
                'roles.edit',
                'roles.update',
                'roles.delete',
            ],
            'menus' => [
                'menus.view',
                'menus.create',
                'menus.store',
                'menus.edit',
                'menus.update',
                'menus.delete',
            ],
            'attributes' => [
                'attributes.view',
                'attributes.create',
                'attributes.store',
                'attributes.edit',
                'attributes.update',
                'attributes.delete',
            ],
            'faqs' => [
                'faqs.view',
                'faqs.create',
                'faqs.store',
                'faqs.edit',
                'faqs.update',
                'faqs.delete',
            ],
            'testimonials' => [
                'testimonials.view',
                'testimonials.create',
                'testimonials.store',
                'testimonials.edit',
                'testimonials.update',
                'testimonials.delete',
            ],
            'pages' => [
                'pages.view',
                'pages.create',
                'pages.store',
                'pages.edit',
                'pages.update',
                'pages.delete',
            ],
            'sliders' => [
                'sliders.view',
                'sliders.create',
                'sliders.store',
                'sliders.edit',
                'sliders.update',
                'sliders.delete',
            ],
            'domains' => [
                'domains.view',
                'domains.create',
                'domains.store',
                'domains.edit',
                'domains.update',
                'domains.delete',
            ],
            'hostings' => [
                'hostings.view',
                'hostings.create',
                'hostings.store',
                'hostings.edit',
                'hostings.update',
                'hostings.delete',
            ],
            'about' => [
                'about.edit',
                'about.update',

            ],
            'about structs' => [
                'about_structs.view',
                'about_structs.create',
                'about_structs.store',
                'about_structs.edit',
                'about_structs.update',
                'about_structs.delete',
            ],
            'benefits' => [
                'benefits.view',
                'benefits.create',
                'benefits.store',
                'benefits.edit',
                'benefits.update',
                'benefits.delete',
            ],
            'site_addresses' => [
                'site_addresses.view',
                'site_addresses.create',
                'site_addresses.store',
                'site_addresses.edit',
                'site_addresses.update',
                'site_addresses.delete',
            ],
            'plans' => [
                'plans.view',
                'plans.create',
                'plans.store',
                'plans.edit',
                'plans.update',
                'plans.delete',
            ],
            'services' => [
                'services.view',
                'services.create',
                'services.store',
                'services.edit',
                'services.update',
                'services.delete',
            ],
            'products' => [
                'products.view',
                'products.create',
                'products.store',
                'products.edit',
                'products.update',
                'products.delete',
            ],
            'projects' => [
                'projects.view',
                'projects.create',
                'projects.store',
                'projects.edit',
                'projects.update',
                'projects.delete',
            ],
            'sections' => [
                'sections.view',
                'sections.create',
                'sections.store',
                'sections.edit',
                'sections.update',
                'sections.delete',
            ],
            'blog_categories' => [
                'blog_categories.view',
                'blog_categories.create',
                'blog_categories.store',
                'blog_categories.edit',
                'blog_categories.update',
                'blog_categories.delete',
            ],
            'blogs' => [
                'blogs.view',
                'blogs.create',
                'blogs.store',
                'blogs.edit',
                'blogs.update',
                'blogs.delete',
            ],
            'authors' => [
                'authors.view',
                'authors.create',
                'authors.store',
                'authors.edit',
                'authors.update',
                'authors.delete',
            ],
            'clients' => [
                'clients.view',
                'clients.create',
                'clients.store',
                'clients.edit',
                'clients.update',
                'clients.delete',
            ],
            'statistics' => [
                'statistics.view',
                'statistics.create',
                'statistics.store',
                'statistics.edit',
                'statistics.update',
                'statistics.delete',
            ],

            'gallery_videos' => [
                'gallery_videos.view',
                'gallery_videos.create',
                'gallery_videos.store',
                'gallery_videos.edit',
                'gallery_videos.update',
                'gallery_videos.delete',
            ],

            'gallery_images' => [
                'gallery_images.view',
                'gallery_images.create',
                'gallery_images.store',
                'gallery_images.edit',
                'gallery_images.update',
                'gallery_images.delete',
            ],
            'job_positions' => [
                'job_positions.view',
                'job_positions.create',
                'job_positions.store',
                'job_positions.edit',
                'job_positions.update',
                'job_positions.delete',
            ],

            'configrations' => [
                'configrations_ar.view',
                'configrations_en.view',
                'configrations.edit',
                'configrations.update',
            ],
            'settings' => [
                'settings.edit',
                'settings.update',
            ],
            'career_applications' => [
                'career_applications.view',
                'career_applications.show',
                'career_applications.download.cv',
                'career_applications.delete',
            ],
            'contact_messages' => [
                'contact_messages.view',
                'contact_messages.show',
                'contact_messages.delete',
            ],

            'subscribers' => [
                'subscribers.view',
                'subscribers.delete',
            ],

            'phones' => [
                'phones.view',
                'phones.create',
                'phones.store',
                'phones.edit',
                'phones.update',
                'phones.delete',
            ],

            'seo_assistants' => [
                'seo_assistants.view',
                'seo_assistants.edit',
                'seo_assistants.update',
            ],
            'ai-content' => [
                'ai-content.view',
                'ai-content.create',
                'ai-content.generate',
                'ai-content.show',
                'ai-content.update',
                'ai-content.delete',
            ],

            'other' => [
                'settings',      
            ],
            'categories' => [
                'categories.view',
                'categories.create',
                'categories.store',
                'categories.edit',
                'categories.update',
                'categories.delete',
            ],
            'albums' => [
                'albums.view',
                'albums.index',
                'albums.create',
                'albums.store',
                'albums.edit',
                'albums.update',
                'albums.delete',
            ],
            'parteners' => [
                'parteners.view',
                'parteners.create',
                'parteners.store',
                'parteners.edit',
                'parteners.update',
                'parteners.delete',
            ],
            'certificates' => [
                'certificates.view',
                'certificates.create',
                'certificates.store',
                'certificates.edit',
                'certificates.update',
                'certificates.delete',
            ],
        ];


        foreach ($groupedPermissions as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin', 'group' => $group]);
            }
        }
    }
}
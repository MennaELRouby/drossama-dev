<?php

namespace Database\Seeders;

use App\Models\Dashboard\AboutUs;
use App\Models\Dashboard\AttributeValue;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            MenuSeeder::class,
            SliderSeeder::class,
            AboutUsSeeder::class,
            AboutStructSeeder::class,
            // HostingSeeder::class,
            // HostingFaqSeeder::class,
            // HostingBenefitSeeder::class,
            CategorySeeder::class,

            FaqSeeder::class,
            SettingSeeder::class,
            BenefitSeeder::class,
            // DomainSeeder::class,
            TestimonialSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            // PlanSeeder::class,
            ServiceSeeder::class,
            SiteAddressSeeder::class,
            ProductSeeder::class,
            BlogCategorySeeder::class,
            AuthorSeeder::class,
            BlogSeeder::class,
            SectionSeeder::class,
            ClientSeeder::class,
            StatisticSeeder::class,
            JobPositionSeeder::class,   
            PageSeeder::class,             
            SeoAssistantSeeder::class,
            PhoneSeeder::class,
            ProjectSeeder::class,
            AlbumSeeder::class,
            PartenerSeeder::class,
            AnalyticsPermissionsSeeder::class,
        ]);
    }
}

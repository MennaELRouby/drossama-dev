<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'site_name',
                'value' => 'My Website',
                'lang' => 'en',
            ],
            [
                'key' => 'site_name',
                'value' => 'موقعي',
                'lang' => 'ar',
            ],
            [
                'key' => 'site_description',
                'value' => 'This is my website description.',
                'lang' => 'en',
            ],
            [
                'key' => 'site_description',
                'value' => 'هذه هي وصف موقعي.',
                'lang' => 'ar',
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'lang' => 'en',
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'lang' => 'ar',
            ],

            [
                'key' => 'site_footer_logo',
                'value' => '',
                'lang' => 'en',
            ],
            [
                'key' => 'site_footer_logo',
                'value' => '',
                'lang' => 'ar',
            ],
            [
                'key' => 'site_favicon',
                'value' => '',
                'lang' => 'en',
            ],
            [
                'key' => 'site_favicon',
                'value' => '',
                'lang' => 'ar',
            ],

            [
                'key' => 'site_footer_text',
                'value' => '© 2023 My Website. All rights reserved.',
                'lang' => 'en',
            ],
            [
                'key' => 'site_footer_text',
                'value' => '© 2025 موقعي. جميع الحقوق محفوظة.',
                'lang' => 'ar',
            ],
            [
                'key' => 'site_copyright',
                'value' => '© 2025 My Website. All rights reserved.',
                'lang' => 'en',
            ],
            [
                'key' => 'site_copyright',
                'value' => '© 2023 موقعي. جميع الحقوق محفوظة.',
                'lang' => 'ar',
            ],
            [
                'key' => 'site_email',
                'value' => 'info@site.com',
                'lang' => 'all',
            ],
            [
                'key' => 'site_whatsapp',
                'value' => '+201016753421',
                'lang' => 'all',
            ],
            [
                'key' => 'site_twitter',
                'value' => 'https://x.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_facebook',
                'value' => 'https://www.facebook.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_instagram',
                'value' => 'https://www.instagram.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_linkedin',
                'value' => 'https://www.linkedin.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_youtube',
                'value' => 'https://www.youtube.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_snapchat',
                'value' => 'https://www.snapchat.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_tiktok',
                'value' => 'https://www.tiktok.com',
                'lang' => 'all',
            ],
            [
                'key' => 'site_pinterest',
                'value' => 'https://www.pinterest.com/',
                'lang' => 'all',
            ],
            [
                'key' => 'site_telegram',
                'value' => 'https://web.telegram.org',
                'lang' => 'all',
            ],
            [
                'key' => 'site_map',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3452.5221691591773!2d31.330127787486845!3d30.079228310203483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583e176f99d6a5%3A0x92096e6818b66f6a!2s25%20Asmaa%20Fahmi%2C%20Al%20Golf%2C%20Heliopolis%2C%20Cairo%20Governorate%204451333!5e0!3m2!1sen!2seg!4v1745182621605!5m2!1sen!2seg',
                'lang' => 'all',
            ],
            [
                'key' => 'google_analytics_id',
                'value' => '',
                'lang' => 'all',
            ],
            [
                'key' => 'google_tag_manager_id',
                'value' => '',
                'lang' => 'all',
            ]
        ];


        foreach ($data as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key'], 'lang' => $item['lang']],
                ['value' => $item['value']]
            );
        }
    }
}

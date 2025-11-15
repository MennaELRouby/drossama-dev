<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phones = [
            [
                'name' => json_encode([
                    'ar' => 'هاتف المبيعات',
                    'en' => 'Sales Phone'
                ]),
                'phone' => '501234567',
                'code' => '+966',
                'email' => 'sales@site.com',
                'description' => json_encode([
                    'ar' => 'هاتف مخصص للمبيعات والاستفسارات العامة',
                    'en' => 'Phone dedicated to sales and general inquiries'
                ]),
                'type' => 'phone',
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode([
                    'ar' => 'واتساب المبيعات',
                    'en' => 'Sales WhatsApp'
                ]),
                'phone' => '507654321',
                'code' => '+966',
                'email' => 'sales@site.com',
                'description' => json_encode([
                    'ar' => 'واتساب مخصص للمبيعات والاستفسارات العامة',
                    'en' => 'WhatsApp dedicated to sales and general inquiries'
                ]),
                'type' => 'whatsapp',
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode([
                    'ar' => 'هاتف الدعم الفني',
                    'en' => 'Technical Support Phone'
                ]),
                'phone' => '509876543',
                'code' => '+966',
                'email' => 'support@site.com',
                'description' => json_encode([
                    'ar' => 'هاتف مخصص للدعم الفني وحل المشاكل',
                    'en' => 'Phone dedicated to technical support and problem solving'
                ]),
                'type' => 'phone',
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode([
                    'ar' => 'واتساب الإدارة',
                    'en' => 'Management WhatsApp'
                ]),
                'phone' => '501112223',
                'code' => '+966',
                'email' => 'admin@site.com',
                'description' => json_encode([
                    'ar' => 'واتساب مخصص للإدارة والشؤون الإدارية',
                    'en' => 'WhatsApp dedicated to management and administrative affairs'
                ]),
                'type' => 'whatsapp',
                'order' => 4,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('phones')->insert($phones);
    }
}

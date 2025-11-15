<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Oldservice;
use App\Models\Oldservice_en;
use App\Models\Service;
use Illuminate\Support\Str;

class MigrateOldServices extends Command
{
    protected $signature = 'migrate:old-services';
    protected $description = 'ترحيل المقالات من service_old و service_olden إلى services';

    public function handle()
    {
        $this->info('🚀 بدء ترحيل الخدمات من service_old و service_olden إلى services...');

        // هات البيانات من الجدولين
        $oldservices_ar = Oldservice::all()->keyBy('service_id');
        $oldservices_en = Oldservice_en::all()->keyBy('service_id');

        $bar = $this->output->createProgressBar($oldservices_ar->count());
        $bar->start();

        foreach ($oldservices_ar as $id => $ar) {
            $en = $oldservices_en->get($id);

            if (!$en) {
                // تخطي لو مش لاقي الإنجليزي
                continue;
            }

            Service::create([
                "id"               => $id,
                'name_ar'         => $ar->title,
                'short_desc_ar'   => $ar->second_description,
                'long_desc_ar'    => $ar->description,
                'slug_ar'         => str_replace([' ', '/', '\\', '?', '#', '[', ']', '@', '!', '$', '&', "'", '(', ')', '*', '+', ',', ';', '=', '%'], '-', trim(preg_replace('/-+/', '-', $ar->title), '-')),
                'name_en'         => $en->title,
                'short_desc_en'   => $en->second_description,
                'long_desc_en'    => $en->description,
                'slug_en'         => Str::slug($en->title),
                'created_at'      => $ar->created_at ?? now(),
                'updated_at'      => $ar->updated_at ?? now(),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ تم ترحيل {$oldservices_ar->count()} خدمة بنجاح.");

        return 0;
    }
}

<?php

namespace App\Helper;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Path
{
    public static function dashboardPath($path)
    {
        $fullPath = public_path('assets/dashboard/' . $path);

        // إضافة timestamp للملف لإجبار المتصفح على تحميل النسخة الجديدة
        if (file_exists($fullPath)) {
            $version = filemtime($fullPath);
            return asset('assets/dashboard/' . $path) . '?v=' . $version;
        }

        return asset('assets/dashboard/' . $path);
    }

    public static function dashboardImage()
    {
        return asset('assets/dashboard');
    }

    public static function css($file)
    {
        $path = 'assets/website/css/' . $file;
        $fullPath = public_path($path);

        // إضافة timestamp للملف لإجبار المتصفح على تحميل النسخة الجديدة
        if (file_exists($fullPath)) {
            $version = filemtime($fullPath);
            return asset($path) . '?v=' . $version;
        }

        return asset($path);
    }

    public static function js($file)
    {
        $path = 'assets/website/js/' . $file;
        $fullPath = public_path($path);

        // إضافة timestamp للملف لإجبار المتصفح على تحميل النسخة الجديدة
        if (file_exists($fullPath)) {
            $version = filemtime($fullPath);
            return asset($path) . '?v=' . $version;
        }

        return asset($path);
    }

    public static function imagesPath($image)
    {
        return asset('assets/website/images/' . $image);
    }

    public static function FrontImage($image)
    {
        return self::imagesPath($image);
    }

    public static function imgPath($image)
    {
        return asset('assets/website/img/' . $image);
    }


    public static function fontsPath($font)
    {
        return asset('assets/website/fonts/' . $font);
    }

    public static function uploadPath()
    {
        return asset('storage/uploads');
    }

    public static function noImagePath()
    {
        return asset('assets/dashboard/images/noimage.png');
    }

    private static function getConfigImage($configKey)
    {
        $file = config("settings.{$configKey}");

        if ($file && filter_var($file, FILTER_VALIDATE_URL)) {
            return $file;
        }

        // تحقق من مجلد configurations أولاً
        if ($file && \Illuminate\Support\Facades\Storage::disk('public')->exists("configurations/{$file}")) {
            return asset("storage/configurations/{$file}");
        }

        // تحقق من مجلد uploads كبديل
        if ($file && \Illuminate\Support\Facades\Storage::disk('public')->exists("uploads/{$file}")) {
            return asset("storage/uploads/{$file}");
        }

        return self::noImagePath();
    }

    public static function AppLogo($configKey = 'site_logo')
    {
        return self::getConfigImage($configKey);
    }

    public static function FooterLogo($configKey = 'site_footer_logo')
    {
        return self::getConfigImage($configKey);
    }

    public static function FavIcon($configKey = 'site_favicon')
    {
        return self::getConfigImage($configKey);
    }

    public static function AppUrl($path = '/', $locale = null)
    {
        return LaravelLocalization::localizeUrl($path, $locale);
    }

    public static function AppName($configKey = 'site_name')
    {
        return config("configrations.{$configKey}") ?? 'ميبيكوم';
    }
}
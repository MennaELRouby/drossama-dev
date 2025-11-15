<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AddNewLanguage extends Command
{
    protected $signature = 'language:add {code} {name} {native} {--regional=}';
    protected $description = 'Add a new language to the multilingual system';

    public function handle()
    {
        $code = $this->argument('code');
        $name = $this->argument('name');
        $native = $this->argument('native');
        $regional = $this->option('regional') ?: $code . '_' . strtoupper($code);

        $this->info("Adding language: {$name} ({$code})");

        // Step 1: Add to config/app.php
        $this->addToAppConfig($code);

        // Step 2: Add to laravellocalization.php
        $this->addToLaravelLocalization($code, $name, $native, $regional);

        // Step 3: Add to multilingual-input component
        $this->addToMultilingualInput($code, $native);

        // Step 4: Create language files
        $this->createLanguageFiles($code);

        // Step 5: Update Request classes
        $this->updateRequestClasses($code);

        // Step 6: Clear cache
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('view:clear');

        $this->info("✅ Language '{$name}' ({$code}) has been added successfully!");
        $this->warn("⚠️  Don't forget to:");
        $this->warn("   1. Translate the language files in lang/{$code}/");
        $this->warn("   2. Update JavaScript in edit pages if needed");
        $this->warn("   3. Test the system thoroughly");
    }

    private function addToAppConfig($code)
    {
        $configPath = config_path('app.php');
        $content = File::get($configPath);

        // Find the form_languages line and add the new language
        $pattern = "/(['\"]form_languages['\"]\s*=>\s*\[)([^\]]+)(\])/";
        $replacement = function ($matches) use ($code) {
            $languages = $matches[2];
            // Check if language already exists
            if (strpos($languages, "'{$code}'") !== false) {
                return $matches[0]; // Already exists
            }
            // Add the new language
            $languages = rtrim($languages, ', ') . ", '{$code}'";
            return $matches[1] . $languages . $matches[3];
        };

        $newContent = preg_replace_callback($pattern, $replacement, $content);
        File::put($configPath, $newContent);

        $this->info("✅ Added to config/app.php");
    }

    private function addToLaravelLocalization($code, $name, $native, $regional)
    {
        $configPath = config_path('laravellocalization.php');
        $content = File::get($configPath);

        // Find the commented line for this language or add new one
        $pattern = "/(\/\/\s*['\"]{$code}['\"]\s*=>\s*\[[^\]]+\])/";
        $replacement = "'{$code}' => ['name' => '{$name}', 'script' => 'Latn', 'native' => '{$native}', 'regional' => '{$regional}'],";

        if (preg_match($pattern, $content)) {
            // Uncomment existing line
            $newContent = preg_replace($pattern, $replacement, $content);
        } else {
            // Add new line before the closing bracket
            $pattern = "/(\s+)(\]\s*,\s*\/\/\s*End of supported locales)/";
            $replacement = "$1'{$code}' => ['name' => '{$name}', 'script' => 'Latn', 'native' => '{$native}', 'regional' => '{$regional}'],\n$1$2";
            $newContent = preg_replace($pattern, $replacement, $content);
        }

        File::put($configPath, $newContent);
        $this->info("✅ Added to config/laravellocalization.php");
    }

    private function addToMultilingualInput($code, $native)
    {
        $componentPath = resource_path('views/components/dashboard/multilingual-input.blade.php');
        $content = File::get($componentPath);

        // Add to languageNames array
        $pattern = "/(\$languageNames\s*=\s*\[)([^\]]+)(\];)/";
        $replacement = function ($matches) use ($code, $native) {
            $languages = $matches[2];
            if (strpos($languages, "'{$code}'") !== false) {
                return $matches[0]; // Already exists
            }
            $languages = rtrim($languages, ', ') . ",\n        '{$code}' => '{$native}',";
            return $matches[1] . $languages . $matches[3];
        };

        $newContent = preg_replace_callback($pattern, $replacement, $content);
        File::put($componentPath, $newContent);

        $this->info("✅ Added to multilingual-input component");
    }

    private function createLanguageFiles($code)
    {
        $langDir = lang_path($code);

        if (!File::exists($langDir)) {
            File::makeDirectory($langDir, 0755, true);
        }

        // Copy from English files
        $files = ['dashboard.php', 'website.php'];

        foreach ($files as $file) {
            $sourcePath = lang_path("en/{$file}");
            $targetPath = lang_path("{$code}/{$file}");

            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $targetPath);
                $this->info("✅ Created lang/{$code}/{$file}");
            }
        }
    }

    private function updateRequestClasses($code)
    {
        $requestFiles = [
            'app/Http/Requests/Dashboard/Services/StoreServiceRequest.php',
            'app/Http/Requests/Dashboard/Services/UpdateServiceRequest.php',
            'app/Http/Requests/Dashboard/Blogs/StoreBlogRequest.php',
            'app/Http/Requests/Dashboard/Blogs/UpdateBlogRequest.php',
            'app/Http/Requests/Dashboard/Products/UpdateProductRequest.php',
            'app/Http/Requests/Dashboard/Hostings/StoreHostingRequest.php',
            'app/Http/Requests/Dashboard/Phones/StorePhoneRequest.php',
        ];

        foreach ($requestFiles as $file) {
            if (File::exists($file)) {
                $this->updateRequestFile($file, $code);
            }
        }
    }

    private function updateRequestFile($filePath, $code)
    {
        $content = File::get($filePath);
        $newContent = $content;

        // Check if the language already exists
        if (strpos($content, "name_{$code}") !== false) {
            return; // Already exists
        }

        // Add validation rules for the new language
        $patterns = [
            // For name fields - try different patterns
            "/(['\"]name_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]name_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]name_ar['\"]\s*=>\s*'[^']+')/",
            // For short_desc fields  
            "/(['\"]short_desc_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]short_desc_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]short_desc_ar['\"]\s*=>\s*'[^']+')/",
            // For long_desc fields
            "/(['\"]long_desc_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]long_desc_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]long_desc_ar['\"]\s*=>\s*'[^']+')/",
            // For meta fields
            "/(['\"]meta_title_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]meta_title_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]meta_title_ar['\"]\s*=>\s*'[^']+')/",
            "/(['\"]meta_desc_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]meta_desc_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]meta_desc_ar['\"]\s*=>\s*'[^']+')/",
            // For slug fields
            "/(['\"]slug_de['\"]\s*=>\s*'[^']+')/",
            "/(['\"]slug_fr['\"]\s*=>\s*'[^']+')/",
            "/(['\"]slug_ar['\"]\s*=>\s*'[^']+')/",
        ];

        $replacements = [
            "'name_de' => 'nullable|string|max:255',\n        'name_{$code}' => 'nullable|string|max:255',",
            "'name_fr' => 'nullable|string|max:255',\n        'name_{$code}' => 'nullable|string|max:255',",
            "'name_ar' => 'required|string|max:255',\n        'name_{$code}' => 'nullable|string|max:255',",
            "'short_desc_de' => 'nullable|string',\n        'short_desc_{$code}' => 'nullable|string',",
            "'short_desc_fr' => 'nullable|string',\n        'short_desc_{$code}' => 'nullable|string',",
            "'short_desc_ar' => 'nullable|string',\n        'short_desc_{$code}' => 'nullable|string',",
            "'long_desc_de' => 'nullable|string',\n        'long_desc_{$code}' => 'nullable|string',",
            "'long_desc_fr' => 'nullable|string',\n        'long_desc_{$code}' => 'nullable|string',",
            "'long_desc_ar' => 'nullable|string',\n        'long_desc_{$code}' => 'nullable|string',",
            "'meta_title_de' => 'nullable|string|max:255',\n        'meta_title_{$code}' => 'nullable|string|max:255',",
            "'meta_title_fr' => 'nullable|string|max:255',\n        'meta_title_{$code}' => 'nullable|string|max:255',",
            "'meta_title_ar' => 'nullable|string|max:255',\n        'meta_title_{$code}' => 'nullable|string|max:255',",
            "'meta_desc_de' => 'nullable|string',\n        'meta_desc_{$code}' => 'nullable|string',",
            "'meta_desc_fr' => 'nullable|string',\n        'meta_desc_{$code}' => 'nullable|string',",
            "'meta_desc_ar' => 'nullable|string',\n        'meta_desc_{$code}' => 'nullable|string',",
            "'slug_de' => 'nullable|string',\n        'slug_{$code}' => 'nullable|string',",
            "'slug_fr' => 'nullable|string',\n        'slug_{$code}' => 'nullable|string',",
            "'slug_ar' => 'nullable|string',\n        'slug_{$code}' => 'nullable|string',",
        ];

        foreach ($patterns as $index => $pattern) {
            $newContent = preg_replace($pattern, $replacements[$index], $newContent);
        }

        // If no patterns matched, try to add after the last name field
        if ($newContent === $content) {
            // Find the last name field and add after it
            $namePattern = "/(['\"]name_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($namePattern, $content, $matches)) {
                $lastNameField = $matches[1];
                $newNameField = str_replace('name_', "name_{$code}", $lastNameField);
                $newNameField = str_replace("'[^']+'", "'nullable|string|max:255'", $newNameField);
                $newContent = str_replace($lastNameField, $lastNameField . "\n        " . $newNameField, $content);
            }
        }

        // If still no patterns matched, try to add after the last short_desc field
        if ($newContent === $content) {
            $shortDescPattern = "/(['\"]short_desc_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($shortDescPattern, $content, $matches)) {
                $lastShortDescField = $matches[1];
                $newShortDescField = str_replace('short_desc_', "short_desc_{$code}", $lastShortDescField);
                $newShortDescField = str_replace("'[^']+'", "'nullable|string'", $newShortDescField);
                $newContent = str_replace($lastShortDescField, $lastShortDescField . "\n        " . $newShortDescField, $content);
            }
        }

        // If still no patterns matched, try to add after the last long_desc field
        if ($newContent === $content) {
            $longDescPattern = "/(['\"]long_desc_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($longDescPattern, $content, $matches)) {
                $lastLongDescField = $matches[1];
                $newLongDescField = str_replace('long_desc_', "long_desc_{$code}", $lastLongDescField);
                $newLongDescField = str_replace("'[^']+'", "'nullable|string'", $newLongDescField);
                $newContent = str_replace($lastLongDescField, $lastLongDescField . "\n        " . $newLongDescField, $content);
            }
        }

        // If still no patterns matched, try to add after the last meta_title field
        if ($newContent === $content) {
            $metaTitlePattern = "/(['\"]meta_title_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($metaTitlePattern, $content, $matches)) {
                $lastMetaTitleField = $matches[1];
                $newMetaTitleField = str_replace('meta_title_', "meta_title_{$code}", $lastMetaTitleField);
                $newMetaTitleField = str_replace("'[^']+'", "'nullable|string|max:255'", $newMetaTitleField);
                $newContent = str_replace($lastMetaTitleField, $lastMetaTitleField . "\n        " . $newMetaTitleField, $content);
            }
        }

        // If still no patterns matched, try to add after the last meta_desc field
        if ($newContent === $content) {
            $metaDescPattern = "/(['\"]meta_desc_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($metaDescPattern, $content, $matches)) {
                $lastMetaDescField = $matches[1];
                $newMetaDescField = str_replace('meta_desc_', "meta_desc_{$code}", $lastMetaDescField);
                $newMetaDescField = str_replace("'[^']+'", "'nullable|string'", $newMetaDescField);
                $newContent = str_replace($lastMetaDescField, $lastMetaDescField . "\n        " . $newMetaDescField, $content);
            }
        }

        // If still no patterns matched, try to add after the last slug field
        if ($newContent === $content) {
            $slugPattern = "/(['\"]slug_[a-z]+['\"]\s*=>\s*'[^']+',)/";
            if (preg_match($slugPattern, $content, $matches)) {
                $lastSlugField = $matches[1];
                $newSlugField = str_replace('slug_', "slug_{$code}", $lastSlugField);
                $newSlugField = str_replace("'[^']+'", "'nullable|string'", $newSlugField);
                $newContent = str_replace($lastSlugField, $lastSlugField . "\n        " . $newSlugField, $content);
            }
        }

        if ($newContent !== $content) {
            File::put($filePath, $newContent);
            $this->info("✅ Updated " . basename($filePath));
        }
    }
}
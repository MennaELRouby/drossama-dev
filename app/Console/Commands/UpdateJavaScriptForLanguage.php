<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateJavaScriptForLanguage extends Command
{
    protected $signature = 'language:update-js {code} {name}';
    protected $description = 'Update JavaScript files to support new language';

    public function handle()
    {
        $code = $this->argument('code');
        $name = $this->argument('name');

        $this->info("Updating JavaScript for language: {$name} ({$code})");

        // Update edit pages
        $this->updateEditPages($code, $name);

        $this->info("✅ JavaScript updated for language '{$name}' ({$code})");
    }

    private function updateEditPages($code, $name)
    {
        $editFiles = [
            'resources/views/Dashboard/Services/edit.blade.php',
            'resources/views/Dashboard/Services/create.blade.php',
            'resources/views/Dashboard/Blogs/edit.blade.php',
            'resources/views/Dashboard/Products/edit.blade.php',
        ];

        foreach ($editFiles as $file) {
            if (File::exists($file)) {
                $this->updateEditFile($file, $code, $name);
            }
        }
    }

    private function updateEditFile($filePath, $code, $name)
    {
        $content = File::get($filePath);

        // Add language to AI prompt auto-fill
        $pattern = "/(var nameFr = \$\(['\"]input\[name=['\"]name_fr['\"]\]\['\"]\)\.val\(\);\s*if \(nameAr\) \{[^}]+\} else if \(nameEn\) \{[^}]+\} else if \(nameFr\) \{[^}]+\})/";
        $replacement = "var nameFr = \$('input[name=\"name_fr\"]').val();\n                    var name{$code} = \$('input[name=\"name_{$code}\"]').val();\n                    if (nameAr) {\n                        prompt = nameAr;\n                        \$('#aiPrompt').val(prompt);\n                    } else if (nameEn) {\n                        prompt = nameEn;\n                        \$('#aiPrompt').val(prompt);\n                    } else if (nameFr) {\n                        prompt = nameFr;\n                        \$('#aiPrompt').val(prompt);\n                    } else if (name{$code}) {\n                        prompt = name{$code};\n                        \$('#aiPrompt').val(prompt);\n                    }";

        $newContent = preg_replace($pattern, $replacement, $content);

        // Add language instruction for AI
        $pattern = "/(} else if \(language === 'en'\) \{[^}]+\} else \{[^}]+\})/";
        $replacement = "} else if (language === 'en') {\n                    languageInstruction = 'Write the text in English only. Format the text using appropriate HTML tags like <h2>, <h3>, <p>, <ul>, <li>, <strong>, <em> to make the content organized and easy to read.';\n                    formattingInstruction = ''; // Already included in English instruction\n                } else if (language === '{$code}') {\n                    languageInstruction = 'Write the text in {$name} only.';\n                } else {\n                    languageInstruction = 'اكتب النص باللغة العربية أولاً، ثم بالإنجليزية.';\n                }";

        $newContent = preg_replace($pattern, $replacement, $newContent);

        if ($newContent !== $content) {
            File::put($filePath, $newContent);
            $this->info("✅ Updated " . basename($filePath));
        }
    }
}

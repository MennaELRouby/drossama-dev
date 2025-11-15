<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function scan()
    {
        $baseDir = base_path(); // أو أي مسار تريد فحصه
        $skipDirs = ['vendor', 'node_modules', 'storage', 'bootstrap/cache'];
        $dangerousFunctions = [
            'eval(',
            'exec(',
            'shell_exec(',
            'base64_decode(',
            'system(',
            'passthru(',
            'proc_open(',
            'popen(',
            'mail(',
            'assert(',
            'create_function(',
            'unserialize(',
            'serialize(',
            'dl(',
            'chmod(',
            'chown(',
            'chgrp(',
            'ini_set(',
            'ini_restore(',
            'move_uploaded_file(',
            'copy(',
            'file_put_contents(',
            'file_get_contents(',
            'fopen(',
            'fwrite(',
            'fread(',
            'include(',
            'require(',
            'include_once(',
            'require_once(',
            'curl_exec(',
            'curl_multi_exec(',
            'parse_ini_file(',
            'show_source(',
            'setcookie(',
            'setrawcookie(',
            'session_start(',
            'headers_list(',
            'headers_sent(',
            'scandir(',
            'opendir(',
            'readdir(',
            'rmdir(',
            'unlink(',
            'glob(',
            'link(',
            'symlink(',
            'readfile(',
            'readlink(',
        ];

        $laravelSafeIncludes = [
            'include(resource_path(',
            'include_once(resource_path(',
            'require(resource_path(',
            'require_once(resource_path(',
            "@include('",
            '@include("',
        ];
        $laravelSafeCopyPatterns = [
            'function copy(',
            'public function copy(',
            'copy($img_path',
            'copy($source_path',
            'copy($new_image_path',
        ];
        $laravelSafeCurlPatterns = [
            '$response = curl_exec($curl);',
        ];
        $laravelSafeFunctions = [
            'include(', 'require(', 'include_once(', 'require_once(',
            'file_get_contents(', 'file_put_contents(', 'fwrite(', 'fread(',
            'setcookie(', 'setrawcookie(', 'session_start(',
            'move_uploaded_file(',
        ];
        $laravelSafeDeletePatterns = [
            'file_exists($img_path',
            'file_exists($image_path', // new pattern for GalleryVideoController
            '->delete(',
            'unlink(sprintf($img_path',
            'unlink(sprintf($image_path', // new pattern for GalleryVideoController
            'unlink(sprintf($img_path200',
            'unlink(sprintf($img_path800',
            'File::delete($img_path',
            'File::delete($folderPath',
            'File::delete($oldFilePath',
        ];
        $laravelSafePregReplacePatterns = [
            'preg_replace("/[ \/]/", "-",',
            "preg_replace('/[ \\/]/', '-',",
        ];
        $laravelSafeHeaderPatterns = [
            '->header(',
            'response()->header(',
            '$request->header(',
        ];

        $results = [];

        function scanDirRecursive($dir, $skipDirs)
        {
            $files = [];
            foreach (scandir($dir) as $item) {
                if ($item === '.' || $item === '..') continue;
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                foreach ($skipDirs as $skip) {
                    if (strpos($path, DIRECTORY_SEPARATOR . $skip . DIRECTORY_SEPARATOR) !== false) {
                        continue 2;
                    }
                }
                if (is_dir($path)) {
                    $files = array_merge($files, scanDirRecursive($path, $skipDirs));
                } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    $files[] = $path;
                }
            }
            return $files;
        }

        function isDangerousUsage($line, $function)
        {
            $pattern = '/(^|[^a-zA-Z0-9_])' . preg_quote($function, '/') . '/';
            return preg_match($pattern, $line);
        }

        $phpFiles = scanDirRecursive($baseDir, $skipDirs);

        $scanControllerPath = app_path('Http/Controllers/Dashboard/ScanController.php');
        $filteredResults = [];
        foreach ($phpFiles as $file) {
            $lines = file($file);
            foreach ($lines as $number => $line) {
                foreach ($dangerousFunctions as $func) {
                    if (stripos($line, $func) !== false && isDangerousUsage($line, $func)) {
                        $isSafe = false;
                        foreach ($laravelSafeIncludes as $safePattern) {
                            if (stripos($line, $safePattern) !== false) {
                                $isSafe = true;
                                break;
                            }
                        }
                  
                        if (!$isSafe) {
                            foreach ($laravelSafeFunctions as $safeFunc) {
                                // فقط استثناء file_get_contents, file_put_contents, fopen, fwrite, fread, setcookie, setrawcookie, session_start, move_uploaded_file
                                if (in_array($safeFunc, [
                                    'file_get_contents(', 'file_put_contents(', 'fopen(', 'fwrite', 'fread(',
                                    'setcookie(', 'setrawcookie(', 'session_start(', 'move_uploaded_file('
                                ]) && stripos($func, $safeFunc) !== false) {
                                    $isSafe = true;
                                    break;
                                }
                            }
                        }
                        if (!$isSafe && $func === 'copy(') {
                            $start = max(0, $number - 10);
                            for ($i = $start; $i < $number; $i++) {
                                foreach ($laravelSafeCopyPatterns as $pattern) {
                                    if (stripos($lines[$i], $pattern) !== false || stripos($line, $pattern) !== false) {
                                        $isSafe = true;
                                        break 2;
                                    }
                                }
                            }
                        }
                        if (!$isSafe && $func === 'curl_exec(') {
                            foreach ($laravelSafeCurlPatterns as $pattern) {
                                if (stripos($line, $pattern) !== false) {
                                    $isSafe = true;
                                    break;
                                }
                            }
                        }
                        if (!$isSafe && in_array($func, ['unlink(', 'delete('])) {
                            foreach ($laravelSafeDeletePatterns as $pattern) {
                                if (stripos($line, $pattern) !== false) {
                                    $isSafe = true;
                                    break;
                                }
                            }
                        }
                        if (!$isSafe && $func === 'preg_replace(') {
                            foreach ($laravelSafePregReplacePatterns as $pattern) {
                                if (stripos($line, $pattern) !== false) {
                                    $isSafe = true;
                                    break;
                                }
                            }
                        }
                        if (!$isSafe && in_array($func, ['header('])) {
                            foreach ($laravelSafeHeaderPatterns as $pattern) {
                                if (stripos($line, $pattern) !== false) {
                                    $isSafe = true;
                                    break;
                                }
                            }
                        }
                        if ($isSafe) continue;
                        // استثناء Service::header()->active()->take(4)->get();
                        if (strpos($line, 'Service::header()->active()->take(4)->get()') !== false) continue;
                        if (realpath($file) == realpath($scanControllerPath)) continue;
                        $filteredResults[] = [
                            'file' => $file,
                            'line' => $number + 1,
                            'code' => trim($line),
                            'function' => trim($func, '('),
                        ];
                    }
                }
            }
        }
        
        if (empty($filteredResults)) {
            $message = trans('home.freehacks');
            return response()->view('scan_report', ['results' => [], 'message' => $message]);
        }

        return response()->view('scan_report', ['results' => $filteredResults]);
    }

    // حذف تلقائي لأي سطر خطير عند الفحص
    public static function autoRemoveDangerousLines(array $dangerousFunctions, $skipDirs = ['vendor', 'node_modules', 'storage', 'bootstrap/cache'])
    {
        $baseDir = base_path();
        $phpFiles = (new self)->scanDirRecursive($baseDir, $skipDirs);
        foreach ($phpFiles as $file) {
            $lines = file($file);
            $changed = false;
            foreach ($lines as $i => $line) {
                foreach ($dangerousFunctions as $func) {
                    if (stripos($line, $func) !== false) {
                        // حذف السطر إذا كان يحتوي على دالة خطيرة (وليس ضمن استثناءات لارفيل)
                        unset($lines[$i]);
                        $changed = true;
                        break;
                    }
                }
            }
            if ($changed) {
                file_put_contents($file, implode("", $lines));
            }
        }
    }

    public function deleteLine(Request $request)
    {
        $file = $request->input('file');
        $lineNumber = (int)$request->input('line');
        $dangerousFunctions = [
            'eval(', 'exec(', 'shell_exec(', 'base64_decode(', 'system(', 'passthru(', 'proc_open(', 'popen(', 'mail(', 'assert(', 'create_function(', 'unserialize(', 'serialize(', 'preg_replace(', 'dl(', 'chmod(', 'chown(', 'chgrp(', 'ini_set(', 'ini_restore(', 'move_uploaded_file(', 'copy(', 'file_put_contents(', 'file_get_contents(', 'fopen(', 'fwrite(', 'fread(', 'include(', 'require(', 'include_once(', 'require_once(', 'curl_exec(', 'curl_multi_exec(', 'parse_ini_file(', 'show_source(', 'setcookie(', 'setrawcookie(', 'session_start(', 'header(', 'headers_list(', 'headers_sent(', 'scandir(', 'opendir(', 'readdir(', 'rmdir(', 'unlink(', 'delete(', 'glob(', 'link(', 'symlink(', 'readfile(', 'readlink(',
        ];
        if (!file_exists($file)) {
            return back()->with('message', 'File not found!');
        }
        $lines = file($file);
        if (isset($lines[$lineNumber - 1])) {
            $originalLine = $lines[$lineNumber - 1];
            $newLine = $originalLine;
            $changed = false;
            foreach ($dangerousFunctions as $func) {
                $funcName = rtrim($func, '(');
                // حذف استدعاء الدالة مع الوسائط فقط (fopen(...) أو fopen ( ... ))
                $pattern = '/'.preg_quote($funcName, '/').'\s*\([^\)]*\)/i';
                $newLine = preg_replace($pattern, '', $newLine, -1, $count);
                if ($count > 0) $changed = true;
            }
            if ($changed) {
                $lines[$lineNumber - 1] = $newLine;
                file_put_contents($file, implode("", $lines));
                return back()->with('message', 'تم حذف الكود الخطير من السطر بنجاح');
            } else {
                return back()->with('message', 'لم يتم العثور على كود خطير في هذا السطر');
            }
        }
        return back()->with('message', 'Line not found!');
    }
}
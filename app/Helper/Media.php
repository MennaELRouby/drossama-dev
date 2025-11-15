<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Media
{
    // Make storeImage static
    public static function uploadAndAttachImage($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Define the full path
            $path = "{$folder}/{$filename}";

            // Initialize ImageManager
            $manager = new ImageManager(new Driver());

            $image = $manager->read($imageFile);

            // Save the image
            Storage::disk('public')->put($path, (string) $image->encode());

            return $filename;
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    // New method using traditional file upload
    public static function uploadAndAttachImageSimple($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Define the full path
            $path = "{$folder}/{$filename}";

            // Use traditional file upload method
            Storage::disk('public')->putFileAs($folder, $imageFile, $filename);

            return $filename;
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    // Ultra simple method for debugging
    public static function uploadAndAttachImageDebug($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Define the full path
            $path = "{$folder}/{$filename}";

            // Use basic file operations
            $imageFile->storeAs("public/{$folder}", $filename);

            return $filename;
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    // Direct file copy method
    public static function uploadAndAttachImageDirect($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Get the storage path
            $storagePath = storage_path("app/public/{$folder}");
            
            // Create directory if it doesn't exist
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Copy file directly
            $imageFile->move($storagePath, $filename);

            return $filename;
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    // Ultra simple copy method
    public static function uploadAndAttachImageCopy($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Get the storage path
            $storagePath = storage_path("app/public/{$folder}");
            
            // Create directory if it doesn't exist
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Get the temporary file path
            $tempPath = $imageFile->getRealPath();
            
            // Copy file using copy() function
            $destinationPath = $storagePath . '/' . $filename;
            if (copy($tempPath, $destinationPath)) {
                return $filename;
            } else {
                throw new \Exception("Failed to copy file");
            }
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    // Storage facade method (most reliable)
    public static function uploadAndAttachImageStorage($imageFile, $folder = 'uploads')
    {
        try {
            // Generate a unique filename
            $filename = $imageFile->hashName();

            // Use Storage facade which handles permissions automatically
            Storage::disk('public')->putFileAs($folder, $imageFile, $filename);

            return $filename;
        } catch (\Exception $e) {
            throw new \Exception("Error storing image: " . $e->getMessage());
        }
    }

    public static function removeFile($folder, $file)
    {
        $path = "{$folder}/{$file}";

        if (Storage::disk('public')->exists($path)) {
            try {
                Storage::disk('public')->delete($path);
            } catch (\Exception $e) {
                throw new \Exception("Failed to delete {$file}: " . $e->getMessage());
            }
        }
    }

    public static function uploadAndAttachFile($file, $folder, $username = 'user')
    {
        try {
            $filename = "{$username}-" . hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs($folder, $file, $filename);

            return $filename;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

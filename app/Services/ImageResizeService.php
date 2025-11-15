<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageResizeService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Generate square PWA icons from original logo
     * 
     * @param string $originalImagePath Original logo path (can be URL or local path)
     * @param array $sizes Array of sizes to generate [152, 192, 512, 96]
     * @return array Array of generated icon paths
     */
    public function generateSquareIcons(string $originalImagePath, array $sizes = [152, 192, 512, 96]): array
    {
        $generatedIcons = [];

        try {
            // Create PWA icons directory if it doesn't exist
            $iconsDirectory = 'pwa-icons';
            Storage::disk('public')->makeDirectory($iconsDirectory);

            // Load the original image
            $image = $this->manager->read($originalImagePath);

            foreach ($sizes as $size) {
                // Create square canvas with white background
                $canvas = $this->manager->create($size, $size)->fill('ffffff');

                // Resize the original image to fit within the square while maintaining aspect ratio
                $resizedImage = $image->scale(width: $size, height: $size);

                // Calculate position to center the image
                $x = ($size - $resizedImage->width()) / 2;
                $y = ($size - $resizedImage->height()) / 2;

                // Place the resized image on the canvas
                $canvas->place($resizedImage, 'top-left', (int)$x, (int)$y);

                // Generate filename
                $filename = "icon-{$size}x{$size}.png";
                $filePath = "{$iconsDirectory}/{$filename}";

                // Save the image
                $fullPath = storage_path("app/public/{$filePath}");
                $canvas->save($fullPath);

                // Store the URL for return
                $generatedIcons[$size] = asset("storage/{$filePath}");
            }

            return $generatedIcons;
        } catch (\Exception $e) {
            // Log the error and return empty array as fallback
            \Illuminate\Support\Facades\Log::error('PWA Icon generation failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generate square PWA icons with transparent background (for better PWA support)
     * 
     * @param string $originalImagePath Original logo path
     * @param array $sizes Array of sizes to generate
     * @return array Array of generated icon paths
     */
    public function generateTransparentSquareIcons(string $originalImagePath, array $sizes = [152, 192, 512, 96]): array
    {
        $generatedIcons = [];

        try {
            // Create PWA icons directory if it doesn't exist
            $iconsDirectory = 'pwa-icons';
            Storage::disk('public')->makeDirectory($iconsDirectory);

            // Load the original image
            $image = $this->manager->read($originalImagePath);

            foreach ($sizes as $size) {
                // Create transparent square canvas
                $canvas = $this->manager->create($size, $size);

                // Resize the original image to fit within the square while maintaining aspect ratio
                $resizedImage = $image->scale(width: $size, height: $size);

                // Calculate position to center the image
                $x = ($size - $resizedImage->width()) / 2;
                $y = ($size - $resizedImage->height()) / 2;

                // Place the resized image on the canvas
                $canvas->place($resizedImage, 'top-left', (int)$x, (int)$y);

                // Generate filename with transparent suffix
                $filename = "icon-{$size}x{$size}-transparent.png";
                $filePath = "{$iconsDirectory}/{$filename}";

                // Save the image as PNG to preserve transparency
                $fullPath = storage_path("app/public/{$filePath}");
                $canvas->save($fullPath);

                // Store the URL for return
                $generatedIcons[$size] = asset("storage/{$filePath}");
            }

            return $generatedIcons;
        } catch (\Exception $e) {
            // Log the error and return empty array as fallback
            \Illuminate\Support\Facades\Log::error('PWA Transparent Icon generation failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if PWA icons already exist and are valid
     * 
     * @param array $sizes Array of sizes to check
     * @return bool True if all icons exist
     */
    public function pwaIconsExist(array $sizes = [152, 192, 512, 96]): bool
    {
        foreach ($sizes as $size) {
            $filePath = "pwa-icons/icon-{$size}x{$size}.png";
            if (!Storage::disk('public')->exists($filePath)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get existing PWA icon URLs
     * 
     * @param array $sizes Array of sizes to get
     * @return array Array of icon URLs
     */
    public function getExistingPwaIcons(array $sizes = [152, 192, 512, 96]): array
    {
        $icons = [];

        foreach ($sizes as $size) {
            $filePath = "pwa-icons/icon-{$size}x{$size}.png";
            if (Storage::disk('public')->exists($filePath)) {
                $icons[$size] = asset("storage/{$filePath}");
            }
        }

        return $icons;
    }

    /**
     * Clear existing PWA icons
     * 
     * @return bool True if cleared successfully
     */
    public function clearPwaIcons(): bool
    {
        try {
            $iconsDirectory = 'pwa-icons';
            if (Storage::disk('public')->exists($iconsDirectory)) {
                Storage::disk('public')->deleteDirectory($iconsDirectory);
            }
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to clear PWA icons: ' . $e->getMessage());
            return false;
        }
    }
}
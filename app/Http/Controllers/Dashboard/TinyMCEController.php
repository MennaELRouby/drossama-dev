<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TinyMCEController extends Controller
{
    /**
     * Handle image upload for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB max
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Upload image using Media helper
                $filename = Media::uploadAndAttachImageStorage($file, 'tinymce');

                // Generate the full URL
                $imageUrl = asset('storage/tinymce/' . $filename);

                // Return response in TinyMCE format
                return response()->json([
                    'location' => $imageUrl
                ]);
            }

            return response()->json([
                'error' => 'No file uploaded'
            ], 400);
        } catch (\Exception $e) {
            Log::error('TinyMCE image upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }
}

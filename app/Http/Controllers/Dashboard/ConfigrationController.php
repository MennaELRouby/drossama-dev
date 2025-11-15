<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Configrations\ConfigrationsRequest;
use App\Models\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ConfigrationController extends Controller
{
    public function edit($lang)
    {
        $this->authorize('configrations.edit');
        $settings = Setting::where('lang', $lang)->get();

        // Get raw values without accessors for image handling
        $data['configrations'] = $settings->mapWithKeys(function ($item) {
            // For image fields, get the raw filename from database
            if (in_array($item->key, Setting::IMAGE_KEYS)) {
                $rawValue = $item->getAttributes()['value'] ?? null;
                return [$item->key => $rawValue];
            }
            // For other fields, use the processed value
            return [$item->key => $item->value];
        });
        $data['lang'] = $lang;
        return  view('Dashboard.Configration.edit', $data);
    }

    public function update(ConfigrationsRequest $request,  $lang)
    {
        $this->authorize('configrations.update');
        try {
            DB::beginTransaction();
            $data = $request->all();

            $configrations = Setting::where('lang', $lang)->get();

            foreach ($configrations as $configration) {
                $key = $configration->key;

                if (in_array($key, Setting::IMAGE_KEYS) && $request->hasFile($key)) {
                    // Remove old image
                    if ($configration->value) {
                        Media::removeFile('configurations', $configration->value);
                    }

                    // Upload new image
                    $newImage = Media::uploadAndAttachImage($request->file($key), 'configurations');

                    if ($newImage) {
                        $configration->value = $newImage;
                    }
                } elseif (isset($data[$key])) {
                    // For non-image fields
                    $configration->value = $data[$key];
                }

                $configration->save();
            }
            // Clear settings cache for this language
            Cache::forget("settings_{$lang}");
            DB::commit();
            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\SettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function show()
    {
        $this->authorize('settings.edit');
        $settings = Setting::where('lang', 'all')->pluck('value', 'key');

        // Get PWA settings for both languages
        $pwaSettings = [];
        $pwaKeys = ['site_short_name', 'site_description', 'theme_color', 'background_color', 'site_logo'];

        foreach ($pwaKeys as $key) {
            $pwaSettings[$key . '_ar'] = Setting::where('key', $key)->where('lang', 'ar')->first()?->value ?? '';
            $pwaSettings[$key . '_en'] = Setting::where('key', $key)->where('lang', 'en')->first()?->value ?? '';
        }

        $settings = array_merge($settings->toArray(), $pwaSettings);

        // Ensure site_logo is available for the view
        $settings['site_logo'] = $pwaSettings['site_logo_ar'] ?? $pwaSettings['site_logo_en'] ?? null;

        // Define the known country codes
        $countryCodes = ['+20', '+966', '+971', '+1'];

        $storedNumber = $settings['site_whatsapp'] ?? '';
        $countryCode = '';
        $phoneNumber = $storedNumber;

        foreach ($countryCodes as $code) {
            if (str_starts_with($storedNumber, $code)) {
                $countryCode = $code;
                $phoneNumber = substr($storedNumber, strlen($code));
                break;
            }
        }

        $settings['country_code'] = $countryCode;
        $settings['site_whatsapp'] = $phoneNumber;

        return view('Dashboard.Settings.edit', compact('settings'));
    }

    public function update(SettingsRequest $request)
    {
        $this->authorize('settings.update');
        try {
            // Begin a transaction
            DB::beginTransaction();

            $data = $request->validated();

            $data['site_whatsapp'] = $data['country_code'] . $data['site_whatsapp'];
            $data['phone'] = $data['country_code'] . $data['phone'];

            // Optional: remove the country code key if you don't want to store it separately
            unset($data['country_code']);

            // Handle PWA settings for both languages
            $pwaKeys = ['site_short_name', 'site_description', 'theme_color', 'background_color'];

            foreach ($pwaKeys as $key) {
                // Handle Arabic settings
                if (isset($data[$key . '_ar']) && !empty($data[$key . '_ar'])) {
                    Setting::updateOrCreate(
                        ['key' => $key, 'lang' => 'ar'],
                        ['value' => $data[$key . '_ar']]
                    );
                    unset($data[$key . '_ar']);
                }

                // Handle English settings
                if (isset($data[$key . '_en']) && !empty($data[$key . '_en'])) {
                    Setting::updateOrCreate(
                        ['key' => $key, 'lang' => 'en'],
                        ['value' => $data[$key . '_en']]
                    );
                    unset($data[$key . '_en']);
                }
            }

            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                $logoFile = $request->file('site_logo');
                $logoName = time() . '_' . $logoFile->getClientOriginalName();
                $logoFile->storeAs('public/configurations', $logoName);
                $logoPath = 'configurations/' . $logoName;

                // Save logo for both languages
                Setting::updateOrCreate(
                    ['key' => 'site_logo', 'lang' => 'ar'],
                    ['value' => $logoPath]
                );
                Setting::updateOrCreate(
                    ['key' => 'site_logo', 'lang' => 'en'],
                    ['value' => $logoPath]
                );

                // Also save in general settings
                Setting::updateOrCreate(
                    ['key' => 'site_logo', 'lang' => 'all'],
                    ['value' => $logoPath]
                );
            }

            // Handle other settings (non-PWA)
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key, 'lang' => 'all'],
                    ['value' => $value]
                );
            }

            // Clear settings cache for this language
            Cache::forget("settings");

            DB::commit();

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully') . ' - PWA Manifest settings updated!']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect()->back()->with(['error' => __('dashboard.something_went_wrong')]);
        }
    }
}
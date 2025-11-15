<?php

namespace App\Observers;

use App\Models\Phone;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PhoneObserver
{
    /**
     * Handle the Phone "created" event.
     */
    public function created(Phone $phone): void
    {
        $this->updateServiceWorker();
    }

    /**
     * Handle the Phone "updated" event.
     */
    public function updated(Phone $phone): void
    {
        $this->updateServiceWorker();
    }

    /**
     * Handle the Phone "deleted" event.
     */
    public function deleted(Phone $phone): void
    {
        $this->updateServiceWorker();
    }

    /**
     * Handle the Phone "restored" event.
     */
    public function restored(Phone $phone): void
    {
        $this->updateServiceWorker();
    }

    /**
     * Handle the Phone "force deleted" event.
     */
    public function forceDeleted(Phone $phone): void
    {
        $this->updateServiceWorker();
    }

    /**
     * Update Service Worker with latest data
     */
    private function updateServiceWorker(): void
    {
        try {
            // Run the Service Worker update command in the background
            Artisan::call('sw:update');

            Log::info('Service Worker updated automatically due to phone data change');
        } catch (\Exception $e) {
            Log::error('Failed to update Service Worker automatically: ' . $e->getMessage());
        }
    }
}

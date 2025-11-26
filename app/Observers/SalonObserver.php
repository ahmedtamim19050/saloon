<?php

namespace App\Observers;

use App\Models\Salon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SalonObserver
{
    /**
     * Handle the Salon "created" event.
     */
    public function created(Salon $salon): void
    {
        if ($salon->slug && $salon->status === 'active') {
            $this->updateHostsFile();
        }
    }

    /**
     * Handle the Salon "updated" event.
     */
    public function updated(Salon $salon): void
    {
        if ($salon->isDirty(['slug', 'status'])) {
            $this->updateHostsFile();
        }
    }

    /**
     * Handle the Salon "deleted" event.
     */
    public function deleted(Salon $salon): void
    {
        if ($salon->slug) {
            $this->updateHostsFile();
        }
    }

    /**
     * Update hosts file in background
     */
    protected function updateHostsFile(): void
    {
        try {
            // Run in background to avoid blocking the request
            if (PHP_OS_FAMILY === 'Windows') {
                // Windows: Run PowerShell command in background
                $command = 'Start-Process powershell -ArgumentList "php artisan hosts:update" -WindowStyle Hidden -Verb RunAs';
                pclose(popen("powershell -Command \"$command\"", 'r'));
            } else {
                // Linux/Mac: Run in background
                exec('php artisan hosts:update > /dev/null 2>&1 &');
            }
        } catch (\Exception $e) {
            Log::warning('Could not auto-update hosts file: ' . $e->getMessage());
        }
    }
}

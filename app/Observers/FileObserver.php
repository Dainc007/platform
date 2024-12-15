<?php

namespace App\Observers;

use App\Models\File;
use App\Models\User;
use App\Notifications\NotifyAdmin;
use Illuminate\Support\Facades\Log;

class FileObserver
{
    /**
     * Handle the File "created" event.
     */
    public function created(File $file): void
    {
        //
    }

    /**
     * Handle the File "updated" event.
     */
    public function updated(File $file): void
    {
        if ($file->isDirty('status') && $file->status === 'ready')
        {
            Log::info('user should be notified');
//            $user = User::find(1);
//            $user->notify(NotifyAdmin::class);
        }
    }

    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        //
    }

    /**
     * Handle the File "restored" event.
     */
    public function restored(File $file): void
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
        //
    }
}

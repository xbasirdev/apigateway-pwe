<?php

declare (strict_types = 1);

namespace App\Listeners;

use App\Events\PasswordResetEvent;
use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PasswordResetListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PasswordResetEvent $event)
    {
        $event->user->notify(new PasswordResetNotification($event->user));
    }

    /**
     * Handle a job failure.
     *
     * @param  Databyte\WhmCpanelManager\Events\PasswordResetEvent  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(PasswordResetEvent $event, $exception)
    {
        Log::error(__("Password reset cannot be sent to user"), [
            'errors' => json_encode($exception->getMessage()),
            'code' => $exception->getCode(),
        ]);
    }
}

<?php

declare (strict_types = 1);

namespace App\Listeners;

use App\Events\ForgotPasswordEvent;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ForgotPasswordListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ForgotPasswordEvent $event)
    {
        $event->user->notify(new ForgotPasswordNotification($event->user, $event->url, $event->exp));
    }

    /**
     * Handle a job failure.
     *
     * @param  Databyte\WhmCpanelManager\Events\ForgotPasswordEvent  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(ForgotPasswordEvent $event, $exception)
    {
        Log::error(__("Forgot Password cannot be sent to user"), [
            'errors' => json_encode($exception->getMessage()),
            'code' => $exception->getCode(),
        ]);
    }
}

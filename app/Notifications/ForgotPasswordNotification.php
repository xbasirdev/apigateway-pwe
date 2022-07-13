<?php

declare (strict_types = 1);

namespace App\Notifications;

use App\Mail\ForgotPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;
    public $url;
    public $exp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $url, $exp)
    {
        $this->user = $user;
        $this->url = $url;
        $this->exp = $exp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = new ForgotPasswordMail($notifiable, $this->user, $this->url, $this->exp);
        return $mail->to($this->user->email);
    }

}

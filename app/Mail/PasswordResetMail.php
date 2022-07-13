<?php

declare (strict_types = 1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $user)
    {
        $this->notifiable = $notifiable;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this
            ->subject("Cambio de clave")
            ->markdown('email.password-reset')
            ->from(env('MAIL_FROM'), env('MAIL_NAME'));

        return $email;
    }
}

<?php

declare (strict_types = 1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $url;
    public $exp;
    public $notifiable;
    public $email_draft;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $user, $url, $exp)
    {
        $this->notifiable = $notifiable;
        $this->user = $user;
        $this->url = $url;
        $this->exp = $exp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this
            ->subject("Confirmación de correo")
            ->markdown('email.forgot-password')
            ->from(env('MAIL_FROM'), env('MAIL_NAME'));

        return $email;
    }

}

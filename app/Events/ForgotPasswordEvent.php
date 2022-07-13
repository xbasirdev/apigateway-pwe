<?php

declare(strict_types = 1);

namespace App\Events;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEvent extends Event
{
    use SerializesModels;
    
    public $user;
    public $url;
    public $exp;
    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $url, $exp)
    {
        $this->user = $user;
        $this->url = $url;
        $this->exp = $exp;
    }
}

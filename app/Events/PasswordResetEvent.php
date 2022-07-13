<?php

declare(strict_types = 1);

namespace App\Events;
use Illuminate\Queue\SerializesModels;

class PasswordResetEvent extends Event
{
    
    use SerializesModels;
    
    public $user;
    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}

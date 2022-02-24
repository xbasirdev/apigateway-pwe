<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class EntryService
{
    use RequestService;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $secret;

    public function __construct()
    {
        $this->baseUri = config('services.entries.base_uri');
        $this->secret = config('services.entries.secret');
    }

    /**
     * @return string
     */
    public function fetchOrders() : string
    {
        return $this->request('GET', '/entries');
    }
}

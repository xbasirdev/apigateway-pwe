<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class BolsaTrabajoService
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

    /**
     * bolsaTrabajoService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchBolsaTrabajos() : string
    {
        return $this->request('GET', '/api/bolsaTrabajo');
    }

    /**
     * @param $bolsaTrabajo
     *
     * @return string
     */
    public function fetchBolsaTrabajo($bolsaTrabajo) : string
    {
        return $this->request('GET', "/api/bolsaTrabajo/{$bolsaTrabajo}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createBolsaTrabajo($data) : string
    {
        return $this->request('POST', '/api/bolsaTrabajo', $data);
    }

    /**
     * @param $bolsaTrabajo
     * @param $data
     *
     * @return string
     */
    public function updateBolsaTrabajo($bolsaTrabajo, $data) : string
    {
        return $this->request('PATCH', "/api/bolsaTrabajo/{$bolsaTrabajo}", $data);
    }

    /**
     * @param $bolsaTrabajo
     *
     * @return string
     */
    public function deleteBolsaTrabajo($bolsaTrabajo) : string
    {
        return $this->request('DELETE', "/api/bolsaTrabajo/{$bolsaTrabajo}");
    }
}

<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class EgresadoService
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
     * egresadoService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchEgresados($data) : string
    {
        return $this->request('POST', '/api/egresado', $data);
    }

    /**
     * @param $egresado
     *
     * @return string
     */
    public function fetchEgresado($egresado) : string
    {
        return $this->request('GET', "/api/egresado/{$egresado}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createEgresado($data) : string
    {
        return $this->request('POST', '/api/egresado/store', $data);
    }

    public function changeNotificationStatus($data) : string
    {
        return $this->request('POST', "/api/egresado/change-notification-status",$data);
    }

    /**
     * @param $egresado
     * @param $data
     *
     * @return string
     */
    public function updateEgresado($egresado, $data) : string
    {
        return $this->request('PATCH', "/api/egresado/{$egresado}", $data);
    }

    /**
     * @param $egresado
     *
     * @return string
     */
    public function deleteEgresado($egresado) : string
    {
        return $this->request('DELETE', "/api/egresado/{$egresado}");
    }

    

    
}

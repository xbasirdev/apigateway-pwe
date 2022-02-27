<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class CarreraService
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
     * carreraService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchCarreras() : string
    {
        return $this->request('GET', '/api/carrera');
    }

    /**
     * @param $carrera
     *
     * @return string
     */
    public function fetchCarrera($carrera) : string
    {
        return $this->request('GET', "/api/carrera/{$carrera}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createCarrera($data) : string
    {
        return $this->request('POST', '/api/carrera', $data);
    }

    /**
     * @param $carrera
     * @param $data
     *
     * @return string
     */
    public function updateCarrera($carrera, $data) : string
    {
        return $this->request('PATCH', "/api/carrera/{$carrera}", $data);
    }

    /**
     * @param $carrera
     *
     * @return string
     */
    public function deleteCarrera($carrera) : string
    {
        return $this->request('DELETE', "/api/carrera/{$carrera}");
    }
}

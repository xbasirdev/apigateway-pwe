<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class BolsaEgresadoService
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
     * bolsaEgresadoService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchBolsaEgresados() : string
    {
        return $this->request('GET', '/api/bolsaEgresado');
    }

    /**
     * @param $bolsaEgresado
     *
     * @return string
     */
    public function fetchBolsaEgresado($bolsaEgresado) : string
    {
        return $this->request('GET', "/api/bolsaEgresado/{$bolsaEgresado}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createBolsaEgresado($data) : string
    {
        return $this->request('POST', '/api/bolsaEgresado', $data);
    }

    /**
     * @param $bolsaEgresado
     * @param $data
     *
     * @return string
     */
    public function updateBolsaEgresado($bolsaEgresado, $data) : string
    {
        return $this->request('PATCH', "/api/bolsaEgresado/{$bolsaEgresado}", $data);
    }

    /**
     * @param $bolsaEgresado
     *
     * @return string
     */
    public function deleteBolsaEgresado($bolsaEgresado) : string
    {
        return $this->request('DELETE', "/api/bolsaEgresado/{$bolsaEgresado}");
    }
}

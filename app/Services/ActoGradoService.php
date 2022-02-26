<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class ActoGradoService
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
     * presentacionesDepService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchActosGrado() : string
    {
        return $this->request('GET', '/api/actoGrado');
    }

    /**
     * @param $actoGrado
     *
     * @return string
     */
    public function fetchActoGrado($acto_grado) : string
    {
        return $this->request('GET', "/api/actoGrado/{$acto_grado}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createActoGrado($data) : string
    {
        return $this->request('POST', '/api/actoGrado', $data);
    }

    /**
     * @param $actoGrado
     * @param $data
     *
     * @return string
     */
    public function updateActoGrado($acto_grado, $data) : string
    {
        return $this->request('PATCH', "/api/actoGrado/{$acto_grado}", $data);
    }

    /**
     * @param $actoGrado
     *
     * @return string
     */
    public function deleteActoGrado($acto_grado) : string
    {
        return $this->request('DELETE', "/api/actoGrado/{$acto_grado}");
    }
}

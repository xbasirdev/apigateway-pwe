<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class PresentacionDepService
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
    public function fetchPresentacionesDep() : string
    {
        return $this->request('GET', '/api/presentacionDep');
    }

    /**
     * @param $presentacionDep
     *
     * @return string
     */
    public function fetchPresentacionDep($presentacion_dep) : string
    {
        return $this->request('GET', "/api/presentacionDep/{$presentacion_dep}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createPresentacionDep($data) : string
    {
        return $this->request('POST', '/api/presentacionDep', $data);
    }

    /**
     * @param $presentacionDep
     * @param $data
     *
     * @return string
     */
    public function updatePresentacionDep($presentacion_dep, $data) : string
    {
        return $this->request('PATCH', "/api/presentacionDep/{$presentacion_dep}", $data);
    }

    /**
     * @param $presentacionDep
     *
     * @return string
     */
    public function deletePresentacionDep($presentacion_dep) : string
    {
        return $this->request('DELETE', "/api/presentacionDep/{$presentacion_dep}");
    }
}

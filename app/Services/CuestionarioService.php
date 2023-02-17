<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class CuestionarioService
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
     * cuestionarioService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchCuestionarios() : string
    {
        return $this->request('GET', '/api/cuestionario');
    }

    /**
     * @param $cuestionario
     *
     * @return string
     */
    public function fetchCuestionario($cuestionario) : string
    {
        return $this->request('GET', "/api/cuestionario/{$cuestionario}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createCuestionario($data) : string
    {
        return $this->request('POST', '/api/cuestionario', $data);
    }

    /**
     * @param $cuestionario
     * @param $data
     *
     * @return string
     */
    public function updateCuestionario($cuestionario, $data) : string
    {
        return $this->request('PATCH', "/api/cuestionario/{$cuestionario}", $data);
    }

    /**
     * @param $cuestionario
     *
     * @return string
     */
    public function deleteCuestionario($cuestionario) : string
    {
        return $this->request('DELETE', "/api/cuestionario/{$cuestionario}");
    }

    public function exportR($cuestionario, $data) : string
    {
        return $this->request('POST', "/api/cuestionario/export-r/{$cuestionario}", $data);
    }

    public function exportD($cuestionario, $data) : string
    {
        return $this->request('POST', "/api/cuestionario/export-d/{$cuestionario}", $data);
    }
}

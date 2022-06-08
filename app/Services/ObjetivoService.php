<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class ObjetivoService
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
     * objetivoService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchObjetivos() : string
    {
        return $this->request('GET', '/api/objetivo');
    }

    /**
     * @param $objetivo
     *
     * @return string
     */
    public function fetchObjetivo($objetivo) : string
    {
        return $this->request('GET', "/api/objetivoCuestionario/{$objetivo}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createObjetivo($data) : string
    {
        return $this->request('POST', '/api/objetivo', $data);
    }

    /**
     * @param $objetivo
     * @param $data
     *
     * @return string
     */
    public function updateObjetivo($objetivo, $data) : string
    {
        return $this->request('PATCH', "/api/objetivo/{$objetivo}", $data);
    }

    /**
     * @param $objetivo
     *
     * @return string
     */
    public function deleteObjetivo($objetivo) : string
    {
        return $this->request('DELETE', "/api/objetivo/{$objetivo}");
    }
}

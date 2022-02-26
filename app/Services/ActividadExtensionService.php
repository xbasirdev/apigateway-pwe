<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class ActividadExtensionService
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
    public function fetchActividadesExtension() : string
    {
        return $this->request('GET', '/api/actividadExtension');
    }

    /**
     * @param $actividadExtension
     *
     * @return string
     */
    public function fetchActividadExtension($actividad_extension) : string
    {
        return $this->request('GET', "/api/actividadExtension/{$actividad_extension}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createActividadExtension($data) : string
    {
        return $this->request('POST', '/api/actividadExtension', $data);
    }

    /**
     * @param $actividadExtension
     * @param $data
     *
     * @return string
     */
    public function updateActividadExtension($actividad_extension, $data) : string
    {
        return $this->request('PATCH', "/api/actividadExtension/{$actividad_extension}", $data);
    }

    /**
     * @param $actividadExtension
     *
     * @return string
     */
    public function deleteActividadExtension($actividad_extension) : string
    {
        return $this->request('DELETE', "/api/actividadExtension/{$actividad_extension}");
    }
}

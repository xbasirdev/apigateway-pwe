<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class EventoService
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
     * eventoService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchEventos() : string
    {
        return $this->request('GET', '/api/evento');
    }

    /**
     * @param $evento
     *
     * @return string
     */
    public function fetchEvento($evento) : string
    {
        return $this->request('GET', "/api/evento/{$evento}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createEvento($data) : string
    {
        return $this->request('POST', '/api/evento', $data);
    }

    /**
     * @param $evento
     * @param $data
     *
     * @return string
     */
    public function updateEvento($evento, $data) : string
    {
        return $this->request('PATCH', "/api/evento/{$evento}", $data);
    }

    /**
     * @param $evento
     *
     * @return string
     */
    public function deleteEvento($evento) : string
    {
        return $this->request('DELETE', "/api/evento/{$evento}");
    }
}

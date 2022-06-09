<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class BancoService
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
     * bancoesDepService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchBancos() : string
    {
        return $this->request('GET', '/api/banco');
    }

    /**
     * @param $banco
     *
     * @return string
     */
    public function fetchBanco($banco) : string
    {
        return $this->request('GET', "/api/banco/{$banco}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createBanco($data) : string
    {
        return $this->request('POST', '/api/banco', $data);
    }

    /**
     * @param $banco
     * @param $data
     *
     * @return string
     */
    public function updateBanco($banco, $data) : string
    {
        return $this->request('PATCH', "/api/banco/{$banco}", $data);
    }

    /**
     * @param $banco
     *
     * @return string
     */
    public function deleteBanco($banco) : string
    {
        return $this->request('DELETE', "/api/banco/{$banco}");
    }
}

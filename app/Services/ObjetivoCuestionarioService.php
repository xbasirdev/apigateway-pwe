<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;

use function config;

class ObjetivoCuestionarioService
{
    use RequestService;

    public function fetchObjetivoCuestionario($cuestionario) : string
    {
        return $this->request('GET', "/api/objetivoCuestionario/{$cuestionario}");
    }


}

<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\ObjetivoService;
use Illuminate\Http\Request;

class ObjetivoController extends Controller
{

    private $objetivoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\ObjetivoService $objetivoService
     */
    public function __construct(ObjetivoService $objetivoService)
    {
        $this->objetivoService = $objetivoService;
    }
    
    /**
     * @param $objetivoService
     *
     * @return mixed
     */
    public function show($objetivo)
    {
        return $this->successResponse($this->objetivoService->fetchObjetivo($objetivo));
    }
}

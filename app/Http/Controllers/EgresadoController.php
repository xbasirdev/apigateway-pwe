<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\EgresadoService;
use Illuminate\Http\Request;

class EgresadoController extends Controller
{

    private $egresadoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\EgresadoService $egresadoService
     */
    public function __construct(EgresadoService $egresadoService)
    {
        $this->egresadoService = $egresadoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->egresadoService->fetchEgresados());
    }

    /**
     * @param $egresado
     *
     * @return mixed
     */
    public function show($egresado)
    {
        return $this->successResponse($this->egresadoService->fetchEgresado($egresado));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->egresadoService->createEgresado($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $egresado
     *
     * @return mixed
     */
    public function update(Request $request, $egresado)
    {
        return $this->successResponse($this->egresadoService->updateEgresado($egresado, $request->all()));
    }

    /**
     * @param $egresado
     *
     * @return mixed
     */
    public function destroy($egresado)
    {
        return $this->successResponse($this->egresadoService->deleteEgresado($egresado));
    }
}

<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\BolsaEgresadoService;
use Illuminate\Http\Request;

class BolsaEgresadoController extends Controller
{

    private $bolsaEgresadoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\BolsaEgresadoService $bolsaEgresadoService
     */
    public function __construct(BolsaEgresadoService $bolsaEgresadoService)
    {
        $this->bolsaEgresadoService = $bolsaEgresadoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->bolsaEgresadoService->fetchBolsaEgresados());
    }

    /**
     * @param $bolsaEgresado
     *
     * @return mixed
     */
    public function show($bolsaEgresado)
    {
        return $this->successResponse($this->bolsaEgresadoService->fetchBolsaEgresado($bolsaEgresado));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->bolsaEgresadoService->createBolsaEgresado($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $bolsaEgresado
     *
     * @return mixed
     */
    public function update(Request $request, $bolsaEgresado)
    {
        return $this->successResponse($this->bolsaEgresadoService->updateBolsaEgresado($bolsaEgresado, $request->all()));
    }

    /**
     * @param $bolsaEgresado
     *
     * @return mixed
     */
    public function destroy($bolsaEgresado)
    {
        return $this->successResponse($this->bolsaEgresadoService->deleteBolsaEgresado($bolsaEgresado));
    }
}

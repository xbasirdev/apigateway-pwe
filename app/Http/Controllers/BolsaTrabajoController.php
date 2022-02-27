<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\BolsaTrabajoService;
use Illuminate\Http\Request;

class BolsaTrabajoController extends Controller
{

    private $bolsaTrabajoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\BolsaTrabajoService $bolsaTrabajoService
     */
    public function __construct(BolsaTrabajoService $bolsaTrabajoService)
    {
        $this->bolsaTrabajoService = $bolsaTrabajoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->bolsaTrabajoService->fetchBolsaTrabajos());
    }

    /**
     * @param $bolsaTrabajo
     *
     * @return mixed
     */
    public function show($bolsaTrabajo)
    {
        return $this->successResponse($this->bolsaTrabajoService->fetchBolsaTrabajo($bolsaTrabajo));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->bolsaTrabajoService->createBolsaTrabajo($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $bolsaTrabajo
     *
     * @return mixed
     */
    public function update(Request $request, $bolsaTrabajo)
    {
        return $this->successResponse($this->bolsaTrabajoService->updateBolsaTrabajo($bolsaTrabajo, $request->all()));
    }

    /**
     * @param $bolsaTrabajo
     *
     * @return mixed
     */
    public function destroy($bolsaTrabajo)
    {
        return $this->successResponse($this->bolsaTrabajoService->deleteBolsaTrabajo($bolsaTrabajo));
    }
}

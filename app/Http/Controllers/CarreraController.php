<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\CarreraService;
use Illuminate\Http\Request;

class CarreraController extends Controller
{

    private $carreraService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\CarreraService $carreraService
     */
    public function __construct(CarreraService $carreraService)
    {
        $this->carreraService = $carreraService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->carreraService->fetchCarreras());
    }

    /**
     * @param $carrera
     *
     * @return mixed
     */
    public function show($carrera)
    {
        return $this->successResponse($this->carreraService->fetchCarrera($carrera));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->carreraService->createCarrera($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $carrera
     *
     * @return mixed
     */
    public function update(Request $request, $carrera)
    {
        return $this->successResponse($this->carreraService->updateCarrera($carrera, $request->all()));
    }

    /**
     * @param $carrera
     *
     * @return mixed
     */
    public function destroy($carrera)
    {
        return $this->successResponse($this->carreraService->deleteCarrera($carrera));
    }
}

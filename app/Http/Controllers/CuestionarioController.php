<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\CuestionarioService;
use Illuminate\Http\Request;

class CuestionarioController extends Controller
{

    private $cuestionarioService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\CuestionarioService $cuestionarioService
     */
    public function __construct(CuestionarioService $cuestionarioService)
    {
        $this->cuestionarioService = $cuestionarioService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->cuestionarioService->fetchCuestionarios());
    }

    /**
     * @param $cuestionario
     *
     * @return mixed
     */
    public function show($cuestionario)
    {
        return $this->successResponse($this->cuestionarioService->fetchCuestionario($cuestionario));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->cuestionarioService->createCuestionario($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $cuestionario
     *
     * @return mixed
     */
    public function update(Request $request, $cuestionario)
    {
        return $this->successResponse($this->cuestionarioService->updateCuestionario($cuestionario, $request->all()));
    }

    /**
     * @param $cuestionario
     *
     * @return mixed
     */
    public function destroy($cuestionario)
    {
        return $this->successResponse($this->cuestionarioService->deleteCuestionario($cuestionario));
    }

    public function exportR(Request $request, $cuestionario)
    {
        $rules = [
            'base_format' => 'required',
        ];
        $this->validate($request, $rules);
        $service = $this->cuestionarioService->exportR($cuestionario, $request->all());
        return $this->successResponse($service);
    }

    public function exportD(Request $request, $cuestionario)
    {
        $rules = [
            'base_format' => 'required',
            'total'=>'required|integer',
            'total_dia'=>'required|integer',
            'total_mes'=>'required|integer',
        ];
        $this->validate($request, $rules);
        $service = $this->cuestionarioService->exportD($cuestionario, $request->all());
        return $this->successResponse($service);
    }
}




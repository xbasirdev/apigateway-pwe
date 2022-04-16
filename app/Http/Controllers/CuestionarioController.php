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
}

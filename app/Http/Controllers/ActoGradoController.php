<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\ActoGradoService;
use Illuminate\Http\Request;

class ActoGradoController extends Controller
{

    private $actoGradoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\ActoGradoService $actoGradoService
     */
    public function __construct(ActoGradoService $actoGradoService)
    {
        $this->actoGradoService = $actoGradoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->actoGradoService->fetchActosGrado());
    }

    /**
     * @param $acto_grado
     *
     * @return mixed
     */
    public function show($acto_grado)
    {
        return $this->successResponse($this->actoGradoService->fetchActoGrado($acto_grado));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->actoGradoService->createActoGrado($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $acto_grado
     *
     * @return mixed
     */
    public function update(Request $request, $acto_grado)
    {
        return $this->successResponse($this->actoGradoService->updateActoGrado($acto_grado, $request->all()));
    }

    /**
     * @param $acto_grado
     *
     * @return mixed
     */
    public function destroy($acto_grado)
    {
        return $this->successResponse($this->actoGradoService->deleteActoGrado($acto_grado));
    }
}

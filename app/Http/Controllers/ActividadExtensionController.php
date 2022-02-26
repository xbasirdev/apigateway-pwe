<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\ActividadExtensionService;
use Illuminate\Http\Request;

class ActividadExtensionController extends Controller
{

    private $actividadExtensionService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\ActividadExtensionService $actividadExtensionService
     */
    public function __construct(ActividadExtensionService $actividadExtensionService)
    {
        $this->actividadExtensionService = $actividadExtensionService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->actividadExtensionService->fetchActividadesExtension());
    }

    /**
     * @param $actividad_extension
     *
     * @return mixed
     */
    public function show($actividad_extension)
    {
        return $this->successResponse($this->actividadExtensionService->fetchActividadExtension($actividad_extension));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->actividadExtensionService->createActividadExtension($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $actividad_extension
     *
     * @return mixed
     */
    public function update(Request $request, $actividad_extension)
    {
        return $this->successResponse($this->actividadExtensionService->updateActividadExtension($actividad_extension, $request->all()));
    }

    /**
     * @param $actividad_extension
     *
     * @return mixed
     */
    public function destroy($actividad_extension)
    {
        return $this->successResponse($this->actividadExtensionService->deleteActividadExtension($actividad_extension));
    }
}

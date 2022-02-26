<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\PresentacionDepService;
use Illuminate\Http\Request;

class PresentacionDepController extends Controller
{

    private $presentacionDepService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\PresentacionDepService $presentacionDepService
     */
    public function __construct(PresentacionDepService $presentacionDepService)
    {
        $this->presentacionDepService = $presentacionDepService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->presentacionDepService->fetchPresentacionesDep());
    }

    /**
     * @param $presentacion_dep
     *
     * @return mixed
     */
    public function show($presentacion_dep)
    {
        return $this->successResponse($this->presentacionDepService->fetchPresentacionDep($presentacion_dep));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->presentacionDepService->createPresentacionDep($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $presentacion_dep
     *
     * @return mixed
     */
    public function update(Request $request, $presentacion_dep)
    {
        return $this->successResponse($this->presentacionDepService->updatePresentacionDep($presentacion_dep, $request->all()));
    }

    /**
     * @param $presentacion_dep
     *
     * @return mixed
     */
    public function destroy($presentacion_dep)
    {
        return $this->successResponse($this->presentacionDepService->deletePresentacionDep($presentacion_dep));
    }
}

<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\EgresadoService;
use Illuminate\Http\Request;
use App\Models\User;


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
        $users = User::whereHas('roles', function ($q) {
            return $q->where('slug', 'graduate');
        })->pluck("cedula")->toArray();
        return $this->successResponse($this->egresadoService->fetchEgresados(["users"=>$users]));
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

    public function changeNotificationStatus(Request $request)
    {
        $rules = [
            'status' => 'required|boolean',
            'id' => 'required',
        ];  

        $this->validate($request, $rules);

        return $this->successResponse($this->egresadoService->changeNotificationStatus($request->all()));
    }
}

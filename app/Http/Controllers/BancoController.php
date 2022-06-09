<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\BancoService;
use Illuminate\Http\Request;

class BancoController extends Controller
{

    private $bancoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\BancoService $bancoService
     */
    public function __construct(BancoService $bancoService)
    {
        $this->bancoService = $bancoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->bancoService->fetchBancos());
    }

    /**
     * @param $banco
     *
     * @return mixed
     */
    public function show($banco)
    {
        return $this->successResponse($this->bancoService->fetchBanco($banco));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->bancoService->createBanco($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $banco
     *
     * @return mixed
     */
    public function update(Request $request, $banco)
    {
        return $this->successResponse($this->bancoService->updateBanco($banco, $request->all()));
    }

    /**
     * @param $banco
     *
     * @return mixed
     */
    public function destroy($banco)
    {
        return $this->successResponse($this->bancoService->deleteBanco($banco));
    }
}

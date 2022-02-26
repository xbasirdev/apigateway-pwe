<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\EventoService;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    private $eventoService;

    /**
     * ProductController constructor.
     *
     * @param \App\Services\EventoService $eventoService
     */
    public function __construct(EventoService $eventoService)
    {
        $this->eventoService = $eventoService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->eventoService->fetchEventos());
    }

    /**
     * @param $evento
     *
     * @return mixed
     */
    public function show($evento)
    {
        return $this->successResponse($this->eventoService->fetchEvento($evento));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->eventoService->createEvento($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $evento
     *
     * @return mixed
     */
    public function update(Request $request, $evento)
    {
        return $this->successResponse($this->eventoService->updateEvento($evento, $request->all()));
    }

    /**
     * @param $evento
     *
     * @return mixed
     */
    public function destroy($evento)
    {
        return $this->successResponse($this->eventoService->deleteEvento($evento));
    }
}

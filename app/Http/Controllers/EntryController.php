<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\EntryService;
use Illuminate\Http\Request;

class EntryController extends Controller
{

    protected $entryService;

    public function __construct(EntryService $entryService)
    {
        $this->entryService = $entryService;
    }

    public function index()
    {
        return $this->successResponse($this->entryService->fetchOrders());
    }
}

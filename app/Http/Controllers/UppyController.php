<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Services\ApplicationService;
use App\Services\UppyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UppyController extends Controller
{
    private UppyService $service;

    public function __construct(UppyService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Factory|View|\Illuminate\Contracts\Foundation\Application
     */
    public function view(): Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('uppy');
    }
    /**
     * @param Request $request
     * @return bool
     */
    public function uploadImage(Request $request): bool
    {
        return $this->service->uploadImage($request);
    }
}

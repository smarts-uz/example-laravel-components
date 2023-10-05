<?php

namespace App\Http\Controllers;

use App\Services\UppyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UppyController extends Controller
{
    private UppyService $service;

    public function __construct(UppyService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Factory|View|Application
     */
    public function view(): Factory|View|Application
    {
        Log::info('UppyControllerView',['blade' => 'uppy']);
        return view('uppy');
    }
    /**
     * Image Upload
     *
     * @param Request $request
     * @return bool
     */
    public function uploadImage(Request $request): bool
    {
        Log::info('UppyControllerUploadImage',['request' => $request]);
        return $this->service->uploadImage($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ReportExportService;
use App\Services\ReportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    private ReportExportService $exportService;
    private ReportService $service;

    public function __construct(ReportExportService $exportService,ReportService $service)
    {
        $this->exportService = $exportService;
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('report');
    }
    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function report(): JsonResponse
    {
        return $this->service->report();

    }
    /**
     * @param $model
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function report_export($model, Request $request): BinaryFileResponse
    {
        return $this->exportService->export($model, $request);
    }
}

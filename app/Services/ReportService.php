<?php


namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class ReportService
{

    /**
     * Get All User's Information
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function report(): JsonResponse
    {
        $query = User::query();
        return Datatables::of($query)
            ->make();
    }
}

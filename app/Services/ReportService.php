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
            ->addColumn('DT_RowId', function($data){
                return ['pkey' => $data->id];
            })
            ->addColumn('DT_RowData', function($data){
                return 'row_'.$data->id;
            })
            ->make();
    }
}

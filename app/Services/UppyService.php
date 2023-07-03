<?php


namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class UppyService
{

    /**
     * @param $request
     * @return bool
     */
    public function uploadImage($request): bool
    {
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')
                ->move(public_path("storage/uploads/"), $fileName);

        }
        return is_callable($filePath);
    }
}

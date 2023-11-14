<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EimzoController extends Controller
{
    /**
     * @return View
     */
    public function view($name) : View
    {
        Log::info('EimzoControllerView',['blade' => $name]);
        return view($name);
    }
}

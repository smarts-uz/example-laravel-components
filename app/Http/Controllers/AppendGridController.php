<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AppendGridController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function view(): View|Factory|Application
    {
        return view('append-grid');
    }
}

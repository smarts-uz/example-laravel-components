<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UppyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(ReportController::class)->group(function() {
    Route::get('/', 'view');
    Route::any('/report/request','report')->name('report');
    Route::any('/report/export/{id}','report_export')->name('report_export');

});
Route::controller(UppyController::class)->group(function() {
    Route::get('/uppy', 'view');
    Route::post('/uploadimage/update', 'uploadImage')->name('uploadImage');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

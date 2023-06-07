<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// CSM API Data
Route::get('/states', [App\Http\Controllers\Api\CmsController::class, 'states'])->name('api.cms.states');
Route::get('/chartForState', [App\Http\Controllers\Api\CmsController::class, 'chartForState'])->name('api.cms.chart');
Route::get('/combinedChartForState', [App\Http\Controllers\Api\CmsController::class, 'combinedChartForState'])->name('api.cms.combined');

// Route::get('/cms/chart', App\Http\Controllers\Api\CmsChartDataController::class)->name('api.cms.chart.data');
// Route::get('/cms/map', App\Http\Controllers\Api\CmsMapDataController::class)->name('api.cms.map.data');
// Route::get('/cms/map', App\Http\Controllers\Api\CmsMapDataController::class)->name('api.cms.map.data');
// Route::get('/cms/procedures', App\Http\Controllers\Api\CmsProceduresController::class)->name('api.cms.data.procedures');
// Route::get('/cms/summary', App\Http\Controllers\Api\CmsSummaryController::class)->name('api.cms.data.summary');

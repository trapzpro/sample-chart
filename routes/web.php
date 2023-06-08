<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// demo route
Route::get('/', [App\Http\Controllers\MostBasicPageController::class, 'index'])->name('data');

Route::get('/highchart', [App\Http\Controllers\HighchartPageController::class, 'index'])->name('highchart');

Route::get('/combined', [App\Http\Controllers\CombinedChartPageController::class, 'index'])->name('combined');


Auth::routes();


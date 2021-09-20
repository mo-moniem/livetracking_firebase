<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnapchatController;
use App\Http\Controllers\MapController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('snap-chat',[SnapchatController::class,'login1']);

Route::get('callback',[SnapchatController::class,'callback']);


Route::get('map-markers',[MapController::class,'mapMarkers']);


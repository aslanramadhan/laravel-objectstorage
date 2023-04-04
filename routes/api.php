<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourcesController;

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

Route::get('/', function() {
    return view('welcome');
});

Route::post('/resources/upload', [ResourcesController::class, 'uploadResource'])->name('api.resources.upload');
Route::get('/resources', [ResourcesController::class, 'getResources'])->name('api.resources.retrieve');

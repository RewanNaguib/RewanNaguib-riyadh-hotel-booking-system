<?php

use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\JobsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthenticationController::class, 'register']);
Route::post('/auth/login', [AuthenticationController::class, 'login']);
Route::get('/rooms', [RoomsController::class, 'index']);
Route::get('/jobs', [JobsController::class, 'index']);
Route::post('/jobs/{jobId}', [JobsController::class, 'applyToJob']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthenticationController::class, 'logout']);
    Route::post('/rooms/{roomId}/book', [RoomsController::class, 'bookRoom']);
});

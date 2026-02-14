<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\IncidentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    //Complaints
    Route::apiResource('complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update']);
    //Incidents
    Route::apiResource('incidents', IncidentController::class)->only(['index', 'show', 'store', 'update']);
});

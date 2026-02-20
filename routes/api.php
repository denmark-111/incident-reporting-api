<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('custom.auth');

Route::middleware('custom.auth')->group(function () {
    //Complaints
    Route::apiResource('complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update']);
    //Incidents
    Route::apiResource('incidents', IncidentController::class)->only(['index', 'show', 'store', 'update']);
    //Incident Types
    Route::get('incident-types', [IncidentTypeController::class, 'index']);
    //Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::patch('notifications', [NotificationController::class, 'update']);
});

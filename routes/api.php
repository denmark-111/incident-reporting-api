<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseUpdateController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\CustomFieldController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    //Complaints
    Route::apiResource('complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update']);
    Route::apiResource('complaints.updates', CaseUpdateController::class)->only(['index','store']);
    //Appointments
    Route::apiResource('complaints.appointments', AppointmentController::class)->only(['index', 'store', 'show', 'update']);
    Route::get('appointments/availability', [AppointmentController::class, 'availability']);
    //Incidents
    Route::apiResource('incidents', IncidentController::class)->only(['index', 'show', 'store', 'update']);
    Route::apiResource('incidents.updates', CaseUpdateController::class)->only(['index','store']);
    //Incident Types
    Route::get('incident-types', [IncidentTypeController::class, 'index']);
    //Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::patch('notifications', [NotificationController::class, 'update']);
    //Custom Fields
    Route::apiResource('custom-fields', CustomFieldController::class)->only(['index', 'store', 'show', 'update']);

    //Audit Logs
    Route::apiResource('audit-logs', AuditLogController::class)->only(['index', 'show']);
});

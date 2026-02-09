<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ComplaintController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Complaints
Route::apiResource('complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update']);
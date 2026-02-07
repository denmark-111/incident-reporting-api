<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ComplaintController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //Complaints
    Route::apiResource('complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update']);

});
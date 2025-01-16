<?php

use App\Http\Controllers\Api\ShippingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/shipping', ShippingController::class)->middleware('auth:sanctum');

<?php

use App\Http\Controllers\MetadataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/api/metadata', [MetadataController::class, 'makePublic']);

Route::middleware('auth:sanctum')->get('/api/user', function (Request $request) {
    return $request->user();
});

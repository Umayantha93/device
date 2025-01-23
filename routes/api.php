<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LeasingController;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [DeviceController::class, 'register']);

Route::get('/device/info/{id}', [LeasingController::class, 'getInfo'])->middleware(Authenticate::class);
Route::put('/device/update/{id}', [LeasingController::class, 'updateLeasing'])->middleware(Authenticate::class);
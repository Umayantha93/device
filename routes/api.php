<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LeasingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [DeviceController::class, 'register']);

Route::get('/device/info/{id}', [LeasingController::class, 'getInfo']);
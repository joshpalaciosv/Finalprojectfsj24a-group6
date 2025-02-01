<?php
// filepath: /c:/Users/Gordo/Documents/ProjectDev/TareasFaltantesKodigo/TareaFinalKodigo/userMgmAPI/routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('user-registrations/day/{date}', [UserController::class, 'registrationsPerDay']);
    Route::get('user-registrations/week/{date}', [UserController::class, 'registrationsPerWeek']);
});

Route::get('/api/test', function () {
    return response()->json(['message' => 'Laravel is working!']);
});
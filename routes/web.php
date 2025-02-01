<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
Route::post('/api/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
});
*/
//Route::resource('users', UserController::class);

Route::get('test', function () {
    return response()->json(['message' => 'Laravel is working!']);
});

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
/*
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});*/



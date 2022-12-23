<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login',[AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']] ,function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('age', [DataController::class, 'age']);
        Route::get('gender', [DataController::class, 'gender']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/store', [UserController::class, 'store']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::put('/update', [UserController::class, 'update']);
    });

 
    Route::get('/roles', [DataController::class, 'roles']);
        
    Route::post('/logout',[AuthController::class, 'logout']);
});

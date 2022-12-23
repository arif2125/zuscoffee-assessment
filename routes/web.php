<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Auth::routes();


//Fallback URL
Route::get('/{any?}', function () {
    return view('layouts.app');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

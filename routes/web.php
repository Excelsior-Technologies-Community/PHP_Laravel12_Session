<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

// Basic session routes (as per original requirement)
Route::get('session/get', [SessionController::class, 'accessSessionData']);
Route::get('session/set', [SessionController::class, 'storeSessionData']);
Route::get('session/remove', [SessionController::class, 'deleteSessionData']);

// Enhanced routes
Route::get('session/clear', [SessionController::class, 'clearSession']);

// View routes
Route::get('/session-test', function () {
    return view('session-test');
});

Route::get('/', function () {
    return redirect('/session-test');
});
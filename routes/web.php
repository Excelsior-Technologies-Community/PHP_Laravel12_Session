<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [SessionController::class, 'dashboard'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Session Form
|--------------------------------------------------------------------------
*/

Route::get('/session/create', [SessionController::class, 'create'])
    ->name('session.create');

Route::post('/session/store', [SessionController::class, 'store'])
    ->name('session.store');

/*
|--------------------------------------------------------------------------
| View Sessions
|--------------------------------------------------------------------------
*/

Route::get('/session/list', [SessionController::class, 'index'])
    ->name('session.list');

/*
|--------------------------------------------------------------------------
| Search Session
|--------------------------------------------------------------------------
*/

Route::get('/session/search', [SessionController::class, 'search'])
    ->name('session.search');

/*
|--------------------------------------------------------------------------
| Remove Single Key
|--------------------------------------------------------------------------
*/

Route::get('/session/remove/{key}', [SessionController::class, 'remove'])
    ->name('session.remove');

/*
|--------------------------------------------------------------------------
| Clear All
|--------------------------------------------------------------------------
*/

Route::get('/session/clear', [SessionController::class, 'clear'])
    ->name('session.clear');

/*
|--------------------------------------------------------------------------
| JSON API
|--------------------------------------------------------------------------
*/

Route::get('/session/json', [SessionController::class, 'get'])
    ->name('session.json');

Route::get('/students', [SessionController::class, 'students'])
    ->name('students');
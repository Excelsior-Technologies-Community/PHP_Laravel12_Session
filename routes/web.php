<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionInspectorController;
use App\Http\Controllers\SessionCartController;

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

/*
|--------------------------------------------------------------------------
| Activity Timeline
|--------------------------------------------------------------------------
*/

Route::get('/session/timeline', [SessionController::class, 'timeline'])
    ->name('session.timeline');


/*
|--------------------------------------------------------------------------
| Flash Message Manager
|--------------------------------------------------------------------------
*/

Route::get('/flash/{type}', [SessionController::class, 'flash'])
    ->name('flash');


Route::get('/flash', [SessionController::class, 'flashPage'])
    ->name('flash.page');

/*
|--------------------------------------------------------------------------
| Active Sessions Inspector & Driver Benchmark
|--------------------------------------------------------------------------
*/
Route::get('/session-inspector', [SessionInspectorController::class, 'index'])->name('session_inspector.index');
Route::post('/session-inspector/revoke/{sessionId}', [SessionInspectorController::class, 'revokeDevice'])->name('session_inspector.revoke');
Route::post('/session-inspector/revoke-others', [SessionInspectorController::class, 'revokeOtherDevices'])->name('session_inspector.revoke_others');
Route::get('/session-inspector/export', [SessionInspectorController::class, 'exportSessionState'])->name('session_inspector.export');

/*
|--------------------------------------------------------------------------
| Session-Based Shopping Cart & 3-Step Checkout Wizard
|--------------------------------------------------------------------------
*/
Route::get('/cart', [SessionCartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [SessionCartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [SessionCartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [SessionCartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/clear', [SessionCartController::class, 'clearCart'])->name('cart.clear');
Route::post('/cart/wizard', [SessionCartController::class, 'processWizardStep'])->name('cart.wizard');
Route::get('/cart/backup', [SessionCartController::class, 'backupCart'])->name('cart.backup');
Route::post('/cart/restore', [SessionCartController::class, 'restoreCart'])->name('cart.restore');
    
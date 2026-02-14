<?php

use App\Http\Controllers\WHMCSController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('font-index');
});
Route::get('/admin', function () {
    return view('backend.login');
})->name('login');
// Route::get('/whmcs/test', [WHMCSController::class, 'test'])->name('admin.dashboard');


Route::any('/login-whmcs', [WHMCSController::class, 'login'])->name('login.whmcs');


// Route::any('/dashboard', [WHMCSController::class, 'index'])->name('admin.dashboard');
Route::middleware(['web', 'auth','whmcsAdmin'])->group(function () {
    Route::any('/dashboard', [WHMCSController::class, 'index'])->name('admin.dashboard');
});

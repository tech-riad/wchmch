<?php

use App\Http\Controllers\WHMCSController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('backend.login');
});
Route::get('/whmcs/test', [WHMCSController::class, 'test']);


Route::post('/login-whmcs', [WHMCSController::class, 'login'])->name('login.whmcs');

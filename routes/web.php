<?php

use App\Http\Controllers\Backend\ClientController;
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

    // User Creation and Management
    Route::get('/users', [ClientController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [ClientController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [ClientController::class, 'store'])->name('admin.users.store');
    Route::get('/users/details', [ClientController::class, 'details'])->name('admin.users.details');
    Route::get('/users/edit/{id}', [ClientController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update/{id}', [ClientController::class, 'update'])->name('admin.users.update');



    Route::get('/users/contact/{id}', [ClientController::class, 'getUserContact'])->name('admin.users.contact');
    Route::post('/users/contact/{id}/create', [ClientController::class, 'createUserContact'])->name('admin.users.contact.create');


    Route::post('/users/contact/update/{clientId}/{contactId}',[ClientController::class, 'updateUserContact'])->name('admin.users.contact.update');






});

<?php

use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\DomainRegistrationCOntroller;
use App\Http\Controllers\Backend\InvoiceDetailsController;
use App\Http\Controllers\Backend\ManageUsersController;
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


    // Product Management
    Route::get('/users/products/{clientId}', [ClientController::class, 'products'])->name('admin.users.products');
    Route::any('/users/products/show/clientid={clientid}productid={productid}',[ClientController::class, 'clientProductShow'])->name('admin.users.product.show');
    Route::post('/users/products/update/clientid={clientid}productid={productid}', [ClientController::class, 'UpdateClientProduct'])->name('admin.users.product.update');
    Route::get('/users/invoices/clientid={clientid}', [ClientController::class, 'invoices'])->name('admin.users.invoices');
    Route::post('/users/invoice/action', [ClientController::class, 'invoiceAction'])->name('admin.users.invoice.action');

    // Invoice Details Controller
    Route::get('/users/invoice/edit/{invoiceid}', [InvoiceDetailsController::class, 'invoiceEdit'])->name('admin.users.invoice.edit');
    Route::any('/users/invoice/update/{invoiceid}', [InvoiceDetailsController::class, 'invoiceUpdate'])->name('admin.users.invoice.update');
    Route::get('/users/invoice/details/{invoiceid}', [InvoiceDetailsController::class, 'invoiceDetails'])->name('admin.users.invoice.details');
    Route::post('/users/invoice/details/add-payment/{invoiceid}', [InvoiceDetailsController::class, 'invoicePaymentAdd'])->name('admin.users.invoice.paymentadd');

    // Transactions
    Route::get('/users/transaction/{clientid}', [ClientController::class, 'transaction'])->name('admin.users.transaction');
    Route::get('/users/add-transaction/{clientid}', [ClientController::class, 'addTransaction'])->name('admin.users.addtransaction');
    Route::post('/users/store-transaction/{clientid}', [ClientController::class, 'storeTransaction'])->name('admin.users.storetransaction');
    Route::get('/admin/users/{clientid}/transaction/{transactionid}/edit', [ClientController::class, 'editTransaction'])
    ->name('admin.users.transaction.edit');

    Route::put('/admin/users/{clientid}/transaction/{transactionid}/update', [ClientController::class, 'updateTransaction'])
        ->name('admin.users.transaction.update');


    // Billable Items
    Route::get('/users/billabeitem/{clientid}', [ClientController::class, 'billableitem'])->name('admin.users.billableitem');
    Route::get('/users/add/billabeitem/{clientid}', [ClientController::class, 'addBillableitem'])->name('admin.users.add.billableitem');
    Route::post('/admin/users/{clientid}/billable-items/store', [ClientController::class, 'storeBillableItem'])
    ->name('admin.users.billableitems.store');

    // Domain
    Route::get('/admin/users/{clientid}/domains', [ClientController::class, 'domains'])
        ->name('admin.users.domains');

    Route::post('/admin/users/{clientid}/domains/{domainid}/update', [ClientController::class, 'updateDomain'])
        ->name('admin.users.domains.update');

    // Manage Users
    Route::get('/admin/users/list', [ManageUsersController::class, 'userList'])->name('admin.users.list');


    // Domain Registrations
    Route::get('/admin/client/domain-registration', [DomainRegistrationCOntroller::class, 'domainRegistration'])->name('admin.domain.registration');




    Route::prefix('admin')->group(function () {
    Route::get('/orders/create/{clientId}', [ClientController::class, 'createOrder'])->name('admin.orders.create');
    Route::post('/orders/store', [ClientController::class, 'storeOrder'])->name('admin.orders.store');

    // AJAX
    Route::get('/orders/ajax/products', [ClientController::class, 'ajaxProducts'])->name('admin.orders.ajax.products');
    Route::get('/orders/ajax/client-domains', [ClientController::class, 'ajaxClientDomains'])->name('admin.orders.ajax.domains');
    Route::get('/orders/ajax/product-pricing', [ClientController::class, 'ajaxProductPricing'])->name('admin.orders.ajax.pricing');
});





});

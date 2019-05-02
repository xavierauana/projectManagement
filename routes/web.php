<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ClientContactController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientInvoiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvoiceController;
use App\Http\Controllers\ProjectOptionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('pdf', function () {
    $pdf = app('dompdf.wrapper');
    $invoice = \App\Invoice::get()->last();
    $pdf->loadHTML(view('pdf.invoice', compact('invoice'))->render());

    return $pdf->stream();
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Auth::routes();
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', HomeController::class . "@index")->name('home');
    Route::get('/profile', HomeController::class . "@profile")->name('profile');
    Route::put('/profile', HomeController::class . "@updateProfile");
    Route::resource('projects', ProjectController::class);
    Route::resource('projects.invoices', ProjectInvoiceController::class);
    Route::post('invoices/pay',
        InvoiceController::class . "@pay")->name('invoices.pay');
    Route::get('invoices/create/type',
        InvoiceController::class . "@getOptions");
    Route::resource('invoices', InvoiceController::class);
    Route::resource('project_options', ProjectOptionController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('clients.contacts', ClientContactController::class);
    Route::resource('clients.invoices', ClientInvoiceController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

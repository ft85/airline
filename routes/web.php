<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Tickets
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/calculate-price', [TicketController::class, 'calculatePrice'])->name('tickets.calculate-price');
    
    // Airlines
    Route::resource('airlines', AirlineController::class);
    
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    
    // Commissions & Reports
    Route::resource('commissions', CommissionController::class)->only(['index', 'show']);
    Route::get('reports/customers', [CommissionController::class, 'customerReport'])->name('reports.customers');
    Route::get('reports/airlines', [CommissionController::class, 'airlineReport'])->name('reports.airlines');
    Route::get('reports/daily', [CommissionController::class, 'dailyReport'])->name('reports.daily');
    Route::get('reports/income', [CommissionController::class, 'incomeReport'])->name('reports.income');
    
    // Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::get('reports/expenses/daily', [ExpenseController::class, 'dailyReport'])->name('reports.expenses.daily');
    Route::resource('expense-categories', ExpenseCategoryController::class)->except(['show']);
    
    // Clients
    Route::resource('clients', ClientController::class);
    Route::post('clients/{client}/payments', [ClientController::class, 'recordPayment'])->name('clients.record-payment');
    Route::get('reports/receivables', [ClientController::class, 'receivablesReport'])->name('reports.receivables');
    
    // Suppliers
    Route::resource('suppliers', SupplierController::class);
    Route::post('suppliers/{supplier}/payments', [SupplierController::class, 'recordPayment'])->name('suppliers.record-payment');
    Route::get('reports/payables', [SupplierController::class, 'payablesReport'])->name('reports.payables');
    
    // Currencies
    Route::resource('currencies', CurrencyController::class)->except(['show']);
});

require __DIR__.'/auth.php';

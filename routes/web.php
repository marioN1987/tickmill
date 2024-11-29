<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'client', 'middleware' => ['auth']], function(){
    Route::get('/list', [ClientController::class, 'list'])->name('clients.list');
    Route::get('/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/update', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('clients.delete');
});

Route::group(['prefix' => 'transaction', 'middleware' => ['auth']], function(){
    Route::get('/list', [TransactionController::class, 'list'])->name('transactions.list');
    Route::get('/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::post('/update', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/delete', [TransactionController::class, 'delete'])->name('transactions.delete');
});

require __DIR__.'/auth.php';

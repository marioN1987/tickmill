<?php

use App\Http\Controllers\ClientController;
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

Route::middleware('auth')->group(function () {
    Route::get('/list', [ClientController::class, 'list'])->name('clients.list');
    Route::get('/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::get('/create', [ClientController::class, 'createPage'])->name('clients.createPage');
    Route::post('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/update', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('clients.delete');
});

require __DIR__.'/auth.php';

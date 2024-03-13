<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'clientes'], function () {
    Route::controller(ClientesController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('clientes.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('clientes.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('clientes.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('clientes.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('clientes.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('clientes.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('clientes.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('clientes.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('clientes.import.post');
    });
});

require __DIR__.'/auth.php';

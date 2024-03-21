<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ModelosController;
use App\Http\Controllers\ProductosController;
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

//Rutas para clientes
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

//Rutas para departamentos
Route::group(['prefix' => 'departamentos'], function () {
    Route::controller(DepartamentosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('departamentos.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('departamentos.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('departamentos.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('departamentos.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('departamentos.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('departamentos.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('departamentos.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('departamentos.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('departamentos.import.post');
    });
});
    //Rutas para categorias
Route::group(['prefix' => 'categorias'], function () {
    Route::controller(CategoriasController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('categorias.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('categorias.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('categorias.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('categorias.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('categorias.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('categorias.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('categorias.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('categorias.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('categorias.import.post');
    });
});
   //Rutas para marcas
   Route::group(['prefix' => 'marcas'], function () {
    Route::controller(MarcasController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('marcas.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('marcas.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('marcas.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('marcas.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('marcas.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('marcas.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('marcas.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('marcas.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('marcas.import.post');
    });
});

    //Rutas modelos
   Route::group(['prefix' => 'modelos'], function () {
    Route::controller(ModelosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('modelos.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('modelos.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('modelos.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('modelos.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('modelos.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('modelos.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('modelos.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('modelos.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('modelos.import.post');
    });
});
    //Rutas modelos
   Route::group(['prefix' => 'productos'], function () {
    Route::controller(ProductosController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('productos.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('productos.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('productos.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('productos.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('productos.update');
        // Route::get('/destoy/{id}', 'destroy')->middleware(['auth'])->name('productos.destroy');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('productos.desactive');
        // Route::get('/import', 'import')->middleware(['auth'])->name('productos.import');
        // Route::post('/import', 'importPost')->middleware(['auth'])->name('productos.import.post');
    });
    

    
});

require __DIR__.'/auth.php';
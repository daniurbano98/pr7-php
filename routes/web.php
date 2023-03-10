<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

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
    return view('main');
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class,'index'])->name('index');
    Route::post('/getBooks', [BookController::class,'getBooksForCategory'])->name('getBooks');
    Route::get('create', [BookController::class,'create'])->name('create');
    Route::get('/{id}', [BookController::class,'show'])->name('show');
    Route::post('/', [BookController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BookController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [BookController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
});

Route::prefix('categories')->group(function (){
    Route::get('/', [CategoryController::class,'index'])->name('index');
    Route::get('create', [CategoryController::class,'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});




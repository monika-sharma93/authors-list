<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;

use App\Http\Middleware\CheckApiToken;




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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.post');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::middleware(['tokenMust'])->group(function () {
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.delete');

    Route::get('/books/create', [BooksController::class, 'create'])->name('books.create');
    Route::post('/books', [BooksController::class, 'store'])->name('books.store'); 
    Route::delete('/books/{id}', [BooksController::class, 'destroy'])->name('books.delete');

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile'); 
       
});

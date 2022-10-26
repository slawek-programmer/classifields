<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassifieldController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Auth::routes();

Route::get('/', [CategoryController::class, 'index'])->name('home');

Route::get('/locale/{lang}', function ($lang) {
	Session::put('locale', $lang);
	return redirect()->back();
})->name('language.change');

Route::middleware('auth')->group(function() {
	Route::get('/ogloszenie/dodaj', [ClassifieldController::class, 'create'])->name('classifield.create');
	
	Route::get('/katekoria/dodaj', [CategoryController::class, 'create'])->name('category.create')->middleware('can:isAdmin');
	Route::post('/kategoria', [CategoryController::class, 'store'])->name('category.store')->middleware('can:isAdmin');
	Route::get('/kategoria/edytuj/{category}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('can:isAdmin');
	Route::post('kategoria/{category}', [CategoryController::class, 'update'])->name('category.update')->middleware('can:isAdmin');
	Route::delete('/kategoria/usun/{category}', [CategoryController::class, 'destroy'])->name('category.delete')->middleware('can:isAdmin');
});
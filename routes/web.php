<?php
  
use Illuminate\Support\Facades\Route;
  
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

//Root route
Route::get('/', function () {
  return view('welcome');
});

//Home route displaying user's entries
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//CRUD for entry
Route::resource('entry', 'EntryController');

// Auth Routes
Auth::routes();

//Test route
Route::get('/test', [App\Http\Controllers\TestController::class, 'getUserID'])->name('test');

//Show the form for creating a new entry
//Route::get('/create', [App\Http\Controllers\EntryController::class, 'create'])->name('create');

//Save new entry
//Route::post('/save', [App\Http\Controllers\EntryController::class, 'store'])->name('save');

//Display specified entry
//Route::get('/show/{id}', [App\Http\Controllers\EntryController::class, 'show'])->name('show');

//Show the form for updating an entry
//Route::get('/edit/{id}', [App\Http\Controllers\EntryController::class, 'edit'])->name('edit');

//Save new entry
//Route::post('/update/{id}', [App\Http\Controllers\EntryController::class, 'update'])->name('update');

//Delete entry
//Route::post('/delete/{id}', [App\Http\Controllers\EntryController::class, 'destroy'])->name('delete');
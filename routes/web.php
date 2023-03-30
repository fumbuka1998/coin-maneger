<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/redirectUser', [HomeController::class, 'redirectUser']);

// Route::get('users', [HomeController::class, 'index']);
Route::get('fetchusers', [HomeController::class, 'fetchStudents']);
Route::post('userstore', [HomeController::class, 'store']);
Route::get('edit-user/{id}', [HomeController::class, 'edit']);
Route::put('update_user/{id}', [HomeController::class, 'update']);
Route::delete('delete-user/{id}', [HomeController::class, 'deleteStudent']);
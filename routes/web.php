<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\ProductsController;
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

Route::get('/', function() {
  return redirect()->route('admin.auth.login');
});
Route::get('/',          	[HomeController::class, 'index']);
Route::get('home',       	[HomeController::class, 'index'])->name('home');

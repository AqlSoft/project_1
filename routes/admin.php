<?php

use App\Http\Controllers\admin\AdminsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
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

Route::group(
    [
        'namespace'     => 'Admin',
        'prefix'        => 'admin',
        'middleware'    => 'auth:admin'
    ],
    function () {

        Route::get('dashboard',                                         [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('operations/log',                                    [HomeController::class, 'log'])->name('operations.log');
        Route::get('dashboard/home',                                    [HomeController::class, 'index'])->name('home.index');
        Route::get('logout',                                            [LoginController::class, 'logout'])->name('logout');

        //=====================================================================================================================================================================
        //======================================================= General Stats ==========================================================================================
        //=====================================================================================================================================================================
        Route::get('home/index',                                         [HomeController::class, 'index'])->name('home.index');
    }
);

Route::group(
    [
        'namespace'     => 'Admin',
        'prefix'        => 'admin',
        'middleware'    => 'guest:admin'
    ],
    function () {
        // Route::get('logout',                                    [LoginController::class, 'logout']);
        // Route::get('logout',                                    [LoginController::class, 'logout']);
        Route::get('/auth/login',                                       [LoginController::class, 'index'])->name('admin.auth.login');
        Route::post('login',                                            [LoginController::class, 'login'])->name('admin.login');
    }
);

Route::group(
    [
        'namespace'     => 'Admin',
        'prefix'        => 'admin',
        'middleware'    => 'auth:admin'
    ],
    function () {

        Route::get('logout',                                [LoginController::class, 'logout'])->name('logout');
        Route::get('home/index',                            [HomeController::class, 'index'])->name('home.index');
        Route::get('admins/all',                            [AdminsController::class, 'index'])->name('display-admins-list');
        Route::get('admins/create',                         [AdminsController::class, 'create'])->name('create-new-admin');
        Route::get('admins/display/profile/{id}',           [AdminsController::class, 'display'])->name('display-admin');
        Route::get('admins/display/roles/{id}',             [AdminsController::class, 'displayRoles'])->name('display-admin-roles');
        Route::get('admins/display/log/{id}',               [AdminsController::class, 'displayLog'])->name('display-admin-log');
        Route::get('admins/edit/{id}',                      [AdminsController::class, 'edit'])->name('edit-admin-info');
        Route::get('admins/destroy/{id}',                   [AdminsController::class, 'destroy'])->name('destroy-admin');
        Route::post('admins/store/',                        [AdminsController::class, 'store'])->name('store-admin-info');
        Route::post('admins/update',                        [AdminsController::class, 'update'])->name('update-admin-info');
        Route::post('assign/role/to/admins',                [AdminsController::class, 'assignRoles'])->name('assign-role-to-admins');
        Route::get('assign/role/to/admin/{admin}/{role}',   [AdminsController::class, 'assignRole'])->name('assign-role-to-admin');
        Route::get('dettach/role/from/admin/{a}/{r}',       [AdminsController::class, 'dettachRole'])->name('dettach-role-from-admin');
        Route::post('dettach/roles/from/admins',            [AdminsController::class, 'assignRoles'])->name('dettach-roles-from-admin');

        //Roles


    }
);

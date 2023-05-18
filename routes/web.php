<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeSalesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ProfileController;

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
    return redirect()->route('login');
})->name('landing');

Route::get('login', function(){
    return view('auth.login');
})->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    //sales
    Route::middleware('sales')->group(function () {
        Route::get('home', [HomeSalesController::class, 'home'])->name('home');
        Route::get('absence', [AttendanceController::class,'createAttendance'])->name('absence');
        Route::post('absence', [AttendanceController::class, 'storeAttendance'])->name('store-attendance');
        Route::get('get-detail/{id}', [AttendanceController::class, 'getDetail'])->name('get-detail');
        Route::put('update-att/{id}', [AttendanceController::class, 'update'])->name('update-att');
        Route::get('my-profile', function () {
            $user = Auth::user();
            return view('profile', compact('user'));
        })->name('my-profile');
        Route::put('update-profile', [AuthController::class, 'updateSalesProfile'])->name('update-profile');
    });
    Route::put('change-password', [AuthController::class, 'updatePassword'])->name('update-password');
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function(){
        Route::get('home', [HomeController::class, 'home'])->name('home');

        Route::get('sales', [HomeController::class, 'sales'])->name('sales');

        //profile
        Route::get('my-profile', [ProfileController::class, 'profile'])->name('profile');
        Route::put('update-profile', [ProfileController::class, 'update'])->name('update-profile');

        //desktop
        Route::prefix('desktop')->name('desktop.')->group(function () {
            //dashboard
            Route::get('home',[HomeController::class, 'homeDesktop'])->name('home');
            Route::get('get-graph', [HomeController::class, 'graphVal'])->name('get-graph');

            //sales
            Route::get('sales', [SalesController::class, 'index'])->name('sales');
            Route::post('sales/store', [SalesController::class, 'store'])->name('sales.store');
            Route::delete('sales/destroy/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
            Route::get('sales/absence/{id}', [SalesController::class, 'absence'])->name('sales.absence');

            //profile
            Route::get('my-profile', [ProfileController::class, 'profileDesktop'])->name('my-profile');
        });

    });
});


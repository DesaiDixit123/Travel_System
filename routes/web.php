<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\CorporateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\QuotationController;

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


// For guests (login, register, forgot-password)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
    Route::get('/register', [CorporateController::class, 'showForm'])->name('register');
    Route::post('/register', [CorporateController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');


});

// For authenticated users
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('corporate.auth');
    Route::get('/Corporate-Details', [CorporateController::class, 'index'])->name('corporates.index');
    Route::get('tables', function () {
		return view('tables');
	})->name('tables');
  Route::get('/Employees', [EmployeeController::class, 'index'])->name('employees.index');
  
  Route::get('/Add-Employees', [EmployeeController::class, 'create'])->name('employees.create');
  Route::get('/Quotations', [QuotationController::class, 'create']);
  Route::get('/Add-Quotation', [QuotationController::class, 'index'])->name('quotations.index');
  ;
  Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');

    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');

 
    
    // Your other routes for authenticated users go here
});

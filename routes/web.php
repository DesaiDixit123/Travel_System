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
    // Route::get('/register', [CorporateController::class, 'showForm'])->name('register');
    // Route::post('/register', [CorporateController::class, 'store']);
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


    Route::get('/add-corporate', [CorporateController::class, 'showForm'])->name('addCorporate.create');
Route::post('/register', [CorporateController::class, 'store'])->name('corporates.store');
Route::get('/corporates/{id}/edit', [CorporateController::class, 'edit'])->name('corporates.edit');
Route::put('/corporates/{id}', [CorporateController::class, 'update'])->name('corporates.update');
Route::delete('/corporates/{id}', [CorporateController::class, 'destroy'])->name('corporates.destroy');
    Route::get('tables', function () {
		return view('tables');
	})->name('tables');
  Route::get('/Employees', [EmployeeController::class, 'index'])->name('employees.index');
  // Show edit form
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

// Update employee
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');

// Delete employee
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
  Route::get('/Add-Employees', [EmployeeController::class, 'create'])->name('employees.create');
  Route::get('/Quotations', [QuotationController::class, 'create'])->name('quotations.create');
  Route::get('/Add-Quotation', [QuotationController::class, 'index'])->name('quotations.index');
  ;
  Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');
Route::post('/quotations/upload/{id}', [QuotationController::class, 'upload'])->name('quotations.upload');

    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::get('quotations/{quotation}/edit', [QuotationController::class, 'edit'])->name('quotations.edit');
    Route::put('quotations/{quotation}', [QuotationController::class, 'update'])->name('quotations.update');
    Route::delete('quotations/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');

    Route::patch('/quotations/{id}/approve', [QuotationController::class, 'approve'])->name('quotations.approve');
    Route::patch('/quotations/{id}/disapprove', [QuotationController::class, 'disapprove'])->name('quotations.disapprove');
    Route::patch('/quotations/{id}/setPending', [QuotationController::class, 'setPending'])->name('quotations.setPending');
    
    // Your other routes for authenticated users go here
});

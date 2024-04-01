<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function () {

    Route::middleware(['guest'])->group(function () {

        Route::view('/login', 'dashboard.user.login')->name('login');
        Route::view('/register', 'dashboard.user.register')->name('register');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::post('/authenticate', [UserController::class, 'check'])->name('check');
    });

    Route::middleware(['auth', 'user.verified'])->group(function () {

        Route::get('/home',    [UserController::class, 'index'])->name('index');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');

        Route::post('/deposit/request/{userId}', [DepositController::class, 'depositRequest'])->name('depositRequest');
        Route::post('/withdraw/request/{userId}', [WithdrawController::class, 'withdrawRequest'])->name('withdrawRequest');
        Route::get('/transactionLog',    [UserController::class, 'transactionLog'])->name('transactionLog');
    });
});

Route::prefix('email')->name('verification.')->group(function () {

    Route::get('/email/verify', [VerificationController::class, 'show'])->name('notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verify');
    Route::post('/email/verify/{id}', [VerificationController::class, 'verifyWithCode'])->name('withCode');
    Route::post('/email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('send');
    Route::get('/email/verify-resend', [VerificationController::class, 'resend'])->name('resend');
});

Route::prefix('admin')->name('admin.')->group(function (){

    Route::middleware(['guest:admin'])->group(function () {

        Route::view('/login', 'dashboard.admin.login')->name('login');
        Route::post('/authenticate', [LoginController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/home', [AdminController::class, 'index'])->name('index');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        Route::get('/methods', [AdminController::class, 'methods'])->name('methods');
        
        Route::get('/users', [AdminController::class, 'userList'])->name('userList');
        Route::post('/user/create', [AdminController::class, 'store'])->name('userCreate');
        Route::post('/user/edit/{userId}', [AdminController::class, 'edit'])->name('userEdit');
        Route::get('/user/delete/{userId}', [AdminController::class, 'delete'])->name('userDelete');
        Route::get('/update-user-active-status' , [AdminController::class, 'updateActiveStatus'])->name('updateActiveStatus');
        Route::post('/update-deposit-status' , [DepositController::class, 'updateDepositStatus'])->name('updateDepositStatus');
        Route::post('/update-withdraw-status' , [WithdrawController::class, 'updateWithdrawStatus'])->name('updateWithdrawStatus');

        Route::get('/deposit/create/methods', [DepositController::class, 'createDepositMethod'])->name('createDepositMethod');
        Route::get('/deposit/edit/methods/{id}', [DepositController::class, 'editDepositMethod'])->name('editDepositMethod');
        Route::get('/deposit/delete/methods/{id}', [DepositController::class, 'deleteDepositMethod'])->name('deleteDepositMethod');
        Route::post('/storeDepostMethods', [DepositController::class, 'storeDepositMethod'])->name('storeDepositMethod');
        
    });
});


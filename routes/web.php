<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DepositMethodController;
use App\Http\Controllers\User\DepositRequestController;
use App\Http\Controllers\User\WithdrawRequestController;
use App\Http\Controllers\Admin\WithdrawMethodController;

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

        Route::post('/deposit/request/{userId}', [DepositRequestController::class, 'depositRequest'])->name('depositRequest');
        Route::post('/withdraw/request/{userId}', [WithdrawRequestController::class, 'withdrawRequest'])->name('withdrawRequest');
        Route::get('/transactionLog',    [UserController::class, 'transactionLog'])->name('transactionLog');
    });
});

Route::prefix('email')->name('verification.')->group(function () {

    Route::get('/verify',             [VerificationController::class, 'show'])->name('notice');
    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verify');
    Route::post('/verify/{id}',       [VerificationController::class, 'verifyWithCode'])->name('withCode');
    Route::post('/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('send');
    Route::get('/verify-resend',      [VerificationController::class, 'resend'])->name('resend');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

        Route::view('/login', 'dashboard.admin.login')->name('login');
        Route::post('/authenticate', [LoginController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/home', [AdminController::class, 'index'])->name('index');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('transaction/logs', [AdminController::class, 'transactionLog']);


        Route::prefix('user')->group(function () {

            Route::get('/',                      [AdminController::class, 'userList'])->name('userList');
            Route::post('/create',               [AdminController::class, 'store'])->name('userCreate');
            Route::post('/edit/{userId}',        [AdminController::class, 'edit'])->name('userEdit');
            Route::get('/delete/{userId}',       [AdminController::class, 'delete'])->name('userDelete');
            Route::post('/update-active-status', [AdminController::class, 'updateActiveStatus'])->name('updateActiveStatus');
        });

        Route::post('/update-deposit-status', [DepositRequestController::class, 'updateDepositStatus'])->name('updateDepositStatus');
        Route::post('/update-withdraw-status', [WithdrawRequestController::class, 'updateWithdrawStatus'])->name('updateWithdrawStatus');

        Route::prefix('deposit/methods')->name('depositMethod.')->group(function () {
            $controller = DepositMethodController::class;

            Route::get('/',             [$controller, 'index'])->name('index');
            Route::get('/create',       [$controller, 'create'])->name('create');
            Route::get('/edit/{id}',    [$controller, 'edit'])->name('edit');
            Route::get('/delete/{id}',  [$controller, 'delete'])->name('delete');
            Route::post('/store',       [$controller, 'store'])->name('store');
            Route::post('/update/{id}', [$controller, 'update'])->name('update');
            Route::post('/status',      [$controller, 'updateActiveStatus'])->name('updateActiveStatus');
            Route::get('/logs',         [$controller, 'logs'])->name('logs');
        });

        Route::prefix('withdraw/methods')->name('withdrawMethod.')->group(function () {
            $controller = WithdrawMethodController::class;

            Route::get('/',             [$controller, 'index'])->name('index');
            Route::get('/create',       [$controller, 'create'])->name('create');
            Route::get('/edit/{id}',    [$controller, 'edit'])->name('edit');
            Route::get('/delete/{id}',  [$controller, 'delete'])->name('delete');
            Route::post('/store',       [$controller, 'store'])->name('store');
            Route::post('/update/{id}', [$controller, 'update'])->name('update');
            Route::post('/status',      [$controller, 'updateActiveStatus'])->name('updateActiveStatus');
            Route::get('/logs',         [$controller, 'logs'])->name('logs');
        });
    });
});

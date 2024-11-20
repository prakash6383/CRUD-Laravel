<?php

use App\Http\Controllers\TraineeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;


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


Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('/');
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::get('reset', [ResetPasswordController::class, 'showResetForm'])->name('reset');
    Route::post('login', [LoginController::class, 'login']);
});

// Route::middleware(['auth.otp_verified'])->group(function () {
// });

Route::post('register', [RegisterController::class, 'register']);
Route::post('password/reset', [ResetPasswordController::class, 'updatePasswordByEmail'])->name('password.update');

Route::middleware(['auth.login'])->group(function () {
    Route::view('index', 'index');
    Route::get('home', [TraineeController::class, 'index']);
    Route::resource('trainees', TraineeController::class);
    Route::controller(TraineeController::class)->group(function () {
        Route::get('trainees-export', 'export')->name('trainees.export');
        Route::post('import', [TraineeController::class, 'import'])->name('import');
        // Route::post('trainees-import', 'import')->name('trainees.import');
    });
    Route::get('/generate-otp', [OTPController::class, 'generateOTP'])->middleware(['auth.otp_verified'])->name('generate-otp');
    Route::get('/verify-otp', function () {
        return view('auth.login');
    })->middleware(['auth.otp_verified'])->name('/verify-otp');
    Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verify-otp');
    Route::get('search', [TraineeController::class, 'search'])->name('trainees.search');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

        Route::get('/schools/fetch', [RegisteredUserController::class, 'fetchSchools'])->name('schools.fetch');

    // facebook authentication
    Route::get('/login/facebook', [SocialController::class, 'facebookRedirect'])->name('login.facebook');
    Route::get('/callback/facebook', [FacebookLoginController::class, 'facebookCallback'])->name('facebook.callback');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //  email passowrd reset

    Route::get('forgot-password', [PasswordResetController::class, 'showForgetPasswordForm'])->name('forget.password.get');

    Route::post('forget-password', [PasswordResetController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('reset.password.get');

    Route::post('reset-password', [PasswordResetController::class, 'submitResetPasswordForm'])->name('reset.password.post');

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

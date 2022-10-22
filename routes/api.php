<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Courses\VideoController;
use App\Http\Controllers\Api\Courses\LessonController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Categories\CategoryController;

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('profile', [ProfileController::class, 'index']);
});

Route::group(['middleware' => ['guest:api']], function () {
    Route::post('register', [RegisterController::class, 'create']);
    Route::post('login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    Route::get('verification/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->name('verification.send');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
});

Route::group([
    'prefix' => '/Lessons',
], function () {
    Route::post('/', [LessonController::class, 'store']);
    Route::get('/{id}', [LessonController::class, 'show']);
    Route::put('/{id}', [LessonController::class, 'update']);
    Route::delete('/{id}', [LessonController::class, 'destroy']);
});

Route::group([
    'prefix' => '/Videos',
], function () {
    Route::post('/', [VideoController::class, 'store']);
    Route::post('/{id}', [VideoController::class, 'update']);
    Route::delete('/{id}', [VideoController::class, 'destroy']);
});

Route::group([
    'prefix' => '/Sections',
], function () {
    Route::post('/', [SectionController::class, 'store']);
    Route::put('/{id}', [SectionController::class, 'update']);
    Route::delete('/{id}', [SectionController::class, 'destroy']);
});

Route::group([
    'prefix' => '/Categories',
], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);

});

<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'checkRole:admin,company'])->group(function () {
    // --- General ---
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // --- Administration ---
    Route::controller(UserController::class)->prefix('users')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::put('/{id}/restore', 'restore')->name('restore');
    });

    // --- Resources ---

    // -- Job Category --
    Route::resource('job-category', JobCategoryController::class)->names('job-category');
    Route::put('job-category/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-category.restore');

    // -- Company --
    Route::resource('company', CompanyController::class)->names('company');
    Route::put('company/{id}/restore', [CompanyController::class, 'restore'])->name('company.restore');

    // -- Job Vacancy --
    Route::resource('job-vacancy', JobVacanciesController::class)->names('job-vacancy');
    Route::put('job-vacancy/{id}/restore', [JobVacanciesController::class, 'restore'])->name('job-vacancy.restore');

    // -- Job Application --
    Route::resource('job-application', JobApplicationController::class)->names('job-application');
    Route::put('job-application/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-application.restore');
});

require __DIR__.'/auth.php';

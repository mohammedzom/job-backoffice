<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashbordController::class, 'index'])->name('dashboard');
    Route::get('/job-vacancies', [JobVacanciesController::class, 'index'])->name('job-vacancy.index');
    Route::get('/job-categories', [JobCategoryController::class, 'index'])->name('category.index');
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('application.index');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/users/{id}/restore', [UserController::class, 'restore'])->name('user.restore');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('job-category', JobCategoryController::class)->names('job-category');
    Route::put('job-category/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-category.restore');

    Route::resource('company', CompanyController::class)->names('company');
    Route::put('company/{id}/restore', [CompanyController::class, 'restore'])->name('company.restore');

    Route::resource('job-vacancy', JobVacanciesController::class)->names('job-vacancy');
    Route::put('job-vacancy/{id}/restore', [JobVacanciesController::class, 'restore'])->name('job-vacancy.restore');

    Route::resource('job-application', JobApplicationController::class)->names('job-application');
    Route::put('job-application/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-application.restore');
});

require __DIR__.'/auth.php';

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
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('job-category', JobCategoryController::class)->names('job-category');
    Route::put('job-category/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-category.restore');
});

require __DIR__.'/auth.php';

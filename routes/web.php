<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    // Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
});
// Portfolio Pages theme-wise
Route::group(['as' => 'portfolio.'], function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
    Route::get('/projects/{slug}', [HomeController::class, 'projectShow'])->name('project.show');
    Route::get('/blog', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('/blog/{slug}', [HomeController::class, 'blogShow'])->name('blog.show');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
    Route::get('/experience', [HomeController::class, 'experience'])->name('experience');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
});

Route::group(['prefix' => 'account', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], 'profile', [DashboardController::class, 'profile'])->name('profile');
    Route::match(['get', 'post'], 'qualification', [DashboardController::class, 'qualification'])->name('qualification');
    Route::match(['get', 'post'], 'skill', [DashboardController::class, 'skill'])->name('skill');
    Route::match(['get', 'post'], 'experience', [DashboardController::class, 'experience'])->name('experience');
    Route::match(['get', 'post'], 'project', [DashboardController::class, 'project'])->name('project');
    Route::match(['get', 'post'], 'blog', [DashboardController::class, 'blog'])->name('blog');
    Route::match(['get', 'post'], 'service', [DashboardController::class, 'service'])->name('service');
    Route::match(['get', 'post'], 'testimonial', [DashboardController::class, 'testimonial'])->name('testimonial');
    Route::match(['get', 'post'], 'contact', [DashboardController::class, 'contact'])->name('contact');
    Route::match(['get', 'post'], 'setting', [DashboardController::class, 'setting'])->name('setting');
});

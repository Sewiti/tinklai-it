<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

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

// Route::view('/', 'app');
Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
Route::get('/problems/create', [ProblemController::class, 'create'])->name('problems.create');
Route::get('/problems/{problemId}', [ProblemController::class, 'show'])->name('problems.show');
Route::put('/problems/{problemId}', [ProblemController::class, 'update'])->name('problems.update');
Route::get('/problems/{problemId}/edit', [ProblemController::class, 'edit'])->name('problems.edit');
Route::delete('/problems/{problemId}', [ProblemController::class, 'destroy'])->name('problems.destroy');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{problemId}', [JobController::class, 'show'])->name('jobs.show');
Route::put('/jobs/{problemId}', [JobController::class, 'update'])->name('jobs.update');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/messages/new', [MessageController::class, 'new'])->name('messages.new');
Route::get('/messages/{recipientId}', [MessageController::class, 'show'])->name('messages.show');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
Route::get('/admin/{problemId}', [AdminController::class, 'show'])->name('admin.show');
Route::put('/admin/{problemId}', [AdminController::class, 'update'])->name('admin.update');

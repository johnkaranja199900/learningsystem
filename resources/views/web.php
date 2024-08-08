<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\admincontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Route::get('/', function () {
    return view('index')->name('index');
});





Route::get('/admin/students', [admincontroller::class, 'index'])->name('admin.staff');
Route::get('/admin/students/{id}/edit', [admincontroller::class, 'edit'])->name('admin.edit');
Route::put('/admin/students/{id}', [admincontroller::class, 'update'])->name('admin.update');
Route::delete('/admin/students/{id}', [admincontroller::class, 'destroy'])->name('admin.destroy');




Route::get('/about',[homecontroller::class,'about'])->name('about');
Route::get('/courses',[homecontroller::class,'courses'])->name('courses');
Route::get('/howto',[homecontroller::class,'howto'])->name('howto');
Route::get('/signup',[homecontroller::class,'signup'])->name('signup');
Route::get('/login',[homecontroller::class,'login'])->name('login');


Route::get('/dashboard', [homecontroller::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'pass'])->name('profile.update');
    Route::get('/student/profile', [ProfileController::class, 'prof'])->name('prof');
    Route::patch('/student/profile', [ProfileController::class, 'updateprof'])->name('updateprof');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
*/
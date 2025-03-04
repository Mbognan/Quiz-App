<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(\App\Http\Controllers\CourseOutcomeController::class)
    ->middleware(['auth'])
    ->group(function(){
        Route::get('/home', 'index')->name('index.home');
        Route::get('/course-outcome', 'index')->name('course-outcome.index');
        Route::get('/learning-objectives/{id}', 'indexLo')->name('learning-objectives.index'); // ✅ Fix route name
    });

Route::controller(\App\Http\Controllers\SubjectController::class)
    ->middleware(['auth'])
    ->group(function(){
        Route::get('/subject', 'index')->name('index.subject');
        Route::post('/subject-create', 'create')->name('create.subject');
        Route::put('/subject-update/{id}', 'update')->name('update.subject');
        Route::delete('/subject-delete/{id}', 'delete')->name('delete.subject');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

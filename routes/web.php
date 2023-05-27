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
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{id}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
    Route::get('/pages/{id}/dumps', [\App\Http\Controllers\PageController::class, 'dumps'])->name('pages.id.dumps.index');
    Route::get('/pages/{id}/dumps/{dumpId}', [\App\Http\Controllers\PageController::class, 'dump'])->name('pages.id.dumps.show');
});

require __DIR__ . '/auth.php';


Route::get('/test', [\App\Http\Controllers\VisitController::class, 'test']);

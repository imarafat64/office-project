<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('demo.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [TodoController::class, 'index'])->name('demo.dashboard');
    Route::get('/blank', [TodoController::class, 'showBlankView'])->name('demo.blank');
    Route::get('/empty', [TodoController::class, 'showEmptyView'])->name('demo.empty');
    Route::get('/completed-todo', [TodoController::class, 'completed'])->name('demo.completed');
    Route::get('/demo/create', [TodoController::class, 'create'])->name('demo.create');
    Route::post('/todo', [TodoController::class, 'store'])->name('demo.store');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('demo.show');
    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('demo.edit');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('demo.destroy');
});

require __DIR__ . '/auth.php';

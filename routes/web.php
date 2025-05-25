<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
    Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users/{userId}/todos', [AdminController::class, 'showUserTodos'])->name('admin.user.todos');
    Route::get('/admin/users/{userId}/comments', [AdminController::class, 'showUserComments'])->name('admin.user.comments');

    Route::get('/todos/{todo}/edit', [AdminController::class, 'editTodo'])->name('admin.todos.edit');
    Route::put('/todos/{todo}', [AdminController::class, 'updateTodo'])->name('admin.todos.update');
    Route::delete('/todos/{todo}', [AdminController::class, 'destroyTodo'])->name('admin.todos.destroy');

    Route::get('/comments/{comment}/edit', [AdminController::class, 'editComment'])->name('admin.comments.edit');
    Route::put('/comments/{comment}', [AdminController::class, 'updateComment'])->name('admin.comments.update');
    Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('admin.comments.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__ . '/auth.php';

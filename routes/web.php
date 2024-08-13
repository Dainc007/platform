<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'friend' => Auth::user(),
        'currentUser' => Auth::user(),
        'conversation' => Conversation::with(['messages' => function ($query) {
            $query->orderBy('id', 'desc');
        }, 'messages.user'])->find(2)
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resources([
//    'articles' => ArticleController::class,
//    'users' => UserController::class,
    'conversations' => ConversationController::class,
    'messages' => MessageController::class,
//    'employees' => EmployeeController::class,
//    'notes' => NoteController::class,
//    'projects' => ProjectController::class,
    'products' => ProductController::class,
    'files' => FileController::class,
    'contractors' => ContractorController::class,
    'brands' => BrandController::class
]);

require __DIR__.'/auth.php';

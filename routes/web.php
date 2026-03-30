<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FtpController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

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
    return redirect()->route('products.index');
    return Inertia::render('Dashboard', [
        'friend' => Auth::user(),
        'currentUser' => Auth::user(),
        'conversation' => \App\Models\Conversation::with(['messages' => function ($query) {
            $query->orderBy('id', 'desc');
        }, 'messages.user'])->find(2)
    ]);
})->middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsActive::class])->name('dashboard');

Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsActive::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('/analytics/truncate', [AnalyticsController::class, 'truncate'])->name('analytics.truncate');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
});

Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsActive::class])->group(function () {
    Route::resources([
        'conversations' => ConversationController::class,
        'messages' => MessageController::class,
        'products' => ProductController::class,
        'files' => FileController::class,
        'contractors' => ContractorController::class,
        'brands' => BrandController::class,
        'analytics' => AnalyticsController::class,
        'ftp' => FtpController::class,
    ]);

    // Admin: User management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggle'])->name('users.toggle');
        Route::get('/users/{user}/activity', [\App\Http\Controllers\Admin\UserManagementController::class, 'activity'])->name('users.activity');
    });
});

Route::middleware(['auth'])->group(function() {
    Route::get('/inactive', function() {
        if (Auth::user()->is_active) {
            return redirect()->intended(route('dashboard'));
        }
        return Inertia::render('Auth/Inactive');
    })->name('inactive');
});

require __DIR__.'/auth.php';

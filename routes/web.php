<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminPanelController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/order', function () {
    return view('order');
})->name('order');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ===== ADMIN PANEL (web) =====
Route::prefix('admin')->group(function () {
    // Public: login
    Route::get('/login', [AdminPanelController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminPanelController::class, 'login'])->name('admin.login.submit');

    // Protected: requires authenticated user
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminPanelController::class, 'logout'])->name('admin.logout');

        Route::get('/', [AdminPanelController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminPanelController::class, 'dashboard']);

        // Menu CRUD
        Route::get('/menu', [AdminPanelController::class, 'menuIndex'])->name('admin.menu');
        Route::post('/menu', [AdminPanelController::class, 'menuStore'])->name('admin.menu.store');
        Route::put('/menu/{id}', [AdminPanelController::class, 'menuUpdate'])->name('admin.menu.update');
        Route::post('/menu/{id}/toggle', [AdminPanelController::class, 'menuToggle'])->name('admin.menu.toggle');
        Route::delete('/menu/{id}', [AdminPanelController::class, 'menuDestroy'])->name('admin.menu.destroy');

        // Orders
        Route::get('/orders', [AdminPanelController::class, 'ordersIndex'])->name('admin.orders');
        Route::get('/orders.json', [AdminPanelController::class, 'ordersJson'])->name('admin.orders.json');
        Route::post('/orders/{id}', [AdminPanelController::class, 'orderUpdate'])->name('admin.orders.update');

        // Messages
        Route::get('/messages', [AdminPanelController::class, 'messagesIndex'])->name('admin.messages');
    });
});

// Legacy URL — redirect to new admin
Route::get('/admin/contacts', function () {
    return redirect()->route('admin.messages');
});

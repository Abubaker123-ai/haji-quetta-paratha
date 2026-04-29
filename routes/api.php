<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;

// Contact (existing)
Route::post('/contact', [ContactController::class, 'apiStore']);
Route::get('/contacts', [ContactController::class, 'apiIndex']);

// Menu (public read, admin write)
Route::get('/menu', [MenuController::class, 'index']);
Route::post('/menu', [MenuController::class, 'store']);
Route::put('/menu/{id}', [MenuController::class, 'update']);
Route::patch('/menu/{id}/toggle', [MenuController::class, 'toggleAvailability']);
Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

// Orders (public create + track, admin read/update)
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}/track', [OrderController::class, 'track']);
Route::get('/orders', [OrderController::class, 'index']);
Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Admin: debug + force seed
Route::get('/admin/debug', [AdminController::class, 'debug']);
Route::post('/admin/seed', [AdminController::class, 'seed']);
Route::post('/admin/seed-admin-user', [AdminController::class, 'seedAdmin']);

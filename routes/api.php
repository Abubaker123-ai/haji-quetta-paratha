<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\DB;
use Database\Seeders\MenuItemSeeder;

// Contact (existing)
Route::post('/contact', [ContactController::class, 'apiStore']);
Route::get('/contacts', [ContactController::class, 'apiIndex']);

// Menu (public read, admin write)
Route::get('/menu', [MenuController::class, 'index']);
Route::post('/menu', [MenuController::class, 'store']);
Route::put('/menu/{id}', [MenuController::class, 'update']);
Route::patch('/menu/{id}/toggle', [MenuController::class, 'toggleAvailability']);
Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

// Orders (public create, admin read/update)
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Admin: debug + force seed
Route::get('/admin/debug', function (Request $request) {
    if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    try {
        $tables = DB::select('SHOW TABLES');
        $menuCount = DB::table('menu_items')->count();
        $ordersCount = DB::table('orders')->count();
        $contactsCount = DB::table('contacts')->count();
        return response()->json([
            'db' => 'connected',
            'menu_items' => $menuCount,
            'orders' => $ordersCount,
            'contacts' => $contactsCount,
            'tables' => $tables,
        ]);
    } catch (\Exception $e) {
        return response()->json(['db' => 'error', 'message' => $e->getMessage()]);
    }
});

Route::post('/admin/seed', function (Request $request) {
    if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    try {
        (new MenuItemSeeder())->run();
        $count = DB::table('menu_items')->count();
        return response()->json(['success' => true, 'menu_items' => $count]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});

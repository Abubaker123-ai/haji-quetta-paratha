<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Database\Seeders\MenuItemSeeder;

class AdminController extends Controller
{
    public function debug(Request $request)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            $menuCount = DB::table('menu_items')->count();
            $ordersCount = DB::table('orders')->count();
            $contactsCount = DB::table('contacts')->count();
            return response()->json([
                'db' => 'connected',
                'menu_items' => $menuCount,
                'orders' => $ordersCount,
                'contacts' => $contactsCount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['db' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function seed(Request $request)
    {
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
    }
}

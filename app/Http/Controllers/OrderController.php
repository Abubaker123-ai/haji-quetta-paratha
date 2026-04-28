<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:30',
            'customer_address' => 'nullable|string|max:1000',
            'order_type'       => 'required|in:pickup,delivery',
            'notes'            => 'nullable|string|max:1000',
            'items'            => 'required|array|min:1',
            'total'            => 'required|numeric|min:0',
            'latitude'         => 'nullable|string',
            'longitude'        => 'nullable|string',
        ]);

        if ($request->order_type === 'delivery' && empty($request->customer_address)) {
            return response()->json([
                'error' => 'Address is required for delivery orders'
            ], 422);
        }

        $order = Order::create([
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'order_type'       => $request->order_type,
            'notes'            => $request->notes,
            'items'            => $request->items,
            'total'            => $request->total,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'status'           => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order'   => $order,
        ], 201);
    }

    public function index(Request $request)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::latest()->get();
        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate(['status' => 'required|string']);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json($order);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Order::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

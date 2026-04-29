<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:30',
            'customer_email'   => 'nullable|email|max:191',
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
            'customer_email'   => $request->customer_email,
            'customer_address' => $request->customer_address,
            'order_type'       => $request->order_type,
            'notes'            => $request->notes,
            'items'            => $request->items,
            'total'            => $request->total,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'status'           => 'pending',
        ]);

        $this->safeSendEmail($order, 'received');

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order'   => $order,
        ], 201);
    }

    /**
     * Queue email AFTER the HTTP response is sent so the API stays fast.
     * Mail errors are logged but never break the order flow.
     */
    private function safeSendEmail(Order $order, string $kind = 'status_change'): void
    {
        if (!$order->customer_email) {
            return;
        }
        $orderId = $order->id;
        $emailKind = $kind;
        defer(function () use ($orderId, $emailKind) {
            try {
                $fresh = Order::find($orderId);
                if ($fresh && $fresh->customer_email) {
                    Mail::to($fresh->customer_email)->send(new OrderStatusMail($fresh, $emailKind));
                }
            } catch (\Throwable $e) {
                Log::warning("Email send failed for order #{$orderId}: " . $e->getMessage());
            }
        });
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

        $request->validate([
            'status'        => 'required|in:pending,preparing,ready,completed,cancelled',
            'admin_message' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);
        $previousStatus = $order->status;
        $order->update([
            'status'            => $request->status,
            'admin_message'     => $request->admin_message,
            'status_updated_at' => now(),
        ]);

        if ($previousStatus !== $order->status || $request->admin_message) {
            $this->safeSendEmail($order, 'status_change');
        }

        return response()->json($order);
    }

    /**
     * Public — customer can track an order by ID
     */
    public function track($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json([
            'id'                => $order->id,
            'status'            => $order->status,
            'admin_message'     => $order->admin_message,
            'order_type'        => $order->order_type,
            'total'             => $order->total,
            'status_updated_at' => $order->status_updated_at,
            'created_at'        => $order->created_at,
        ]);
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

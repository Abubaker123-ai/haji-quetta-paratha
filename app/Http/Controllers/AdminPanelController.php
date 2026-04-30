<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusMail;
use App\Models\Contact;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AdminPanelController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $stats = Cache::remember('admin_dashboard_stats', 30, fn() => [
            'menu_total'    => MenuItem::count(),
            'menu_active'   => MenuItem::where('available', true)->count(),
            'orders_total'  => Order::count(),
            'orders_pending'=> Order::where('status', 'pending')->count(),
            'messages'      => Contact::count(),
        ]);
        $latestOrders = Order::orderByDesc('id')->limit(5)->get();
        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }

    // ----- MENU -----
    public function menuIndex()
    {
        $items = MenuItem::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.menu', compact('items'));
    }

    public function menuStore(Request $request)
    {
        $data = $request->validate([
            'item_id'     => 'required|string|unique:menu_items,item_id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'emoji'       => 'nullable|string|max:10',
            'image_url'   => 'nullable|string|max:500',
        ]);
        $data['available'] = true;
        $data['sort_order'] = MenuItem::max('sort_order') + 1;
        MenuItem::create($data);
        return redirect()->route('admin.menu')->with('ok', 'Item added.');
    }

    public function menuUpdate(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'emoji'       => 'nullable|string|max:10',
            'image_url'   => 'nullable|string|max:500',
        ]);
        $item->update($data);
        return redirect()->route('admin.menu')->with('ok', 'Item updated.');
    }

    public function menuToggle($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->available = !$item->available;
        $item->save();
        return redirect()->route('admin.menu')->with('ok', 'Stock updated.');
    }

    public function menuDestroy($id)
    {
        MenuItem::findOrFail($id)->delete();
        return redirect()->route('admin.menu')->with('ok', 'Item deleted.');
    }

    // ----- ORDERS -----
    public function ordersIndex(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $q = Order::orderByDesc('id');
        if (in_array($filter, ['pending', 'preparing', 'ready', 'completed', 'cancelled'])) {
            $q->where('status', $filter);
        }
        $orders = $q->limit(100)->get();
        return view('admin.orders', compact('orders', 'filter'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'preparing', 'ready', 'completed', 'cancelled'])],
            'admin_message' => 'nullable|string|max:500',
        ]);
        $order = Order::findOrFail($id);
        $previousStatus = $order->status;
        $order->status = $request->status;
        if ($request->has('admin_message')) {
            $order->admin_message = $request->admin_message;
        }
        $order->status_updated_at = now();
        $order->save();

        // Send email after response (non-blocking)
        if ($order->customer_email && ($previousStatus !== $order->status || $request->admin_message)) {
            $orderId = $order->id;
            defer(function () use ($orderId) {
                try {
                    $fresh = Order::find($orderId);
                    if ($fresh && $fresh->customer_email) {
                        Mail::to($fresh->customer_email)->send(new OrderStatusMail($fresh, 'status_change'));
                    }
                } catch (\Throwable $e) {
                    Log::warning("Admin email failed for order #{$orderId}: " . $e->getMessage());
                }
            });
            $emailNote = $order->customer_email ? " Email notification queued for {$order->customer_email}." : '';
        } else {
            $emailNote = '';
        }

        return back()->with('ok', "Order #$id updated to {$request->status}.{$emailNote}");
    }

    public function orderDestroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return back()->with('ok', "Order #$id has been deleted.");
    }

    public function ordersJson(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $q = Order::orderByDesc('id')->select('id','status','created_at');
        if (in_array($filter, ['pending', 'preparing', 'ready', 'completed', 'cancelled'])) {
            $q->where('status', $filter);
        }
        $pendingCount = Cache::remember('pending_orders_count', 5, fn() =>
            Order::where('status', 'pending')->count()
        );
        return response()->json([
            'pending_count' => $pendingCount,
            'server_time'   => now()->toIso8601String(),
        ])->withHeaders([
            'Cache-Control' => 'no-store',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    // ----- MESSAGES -----
    public function messagesIndex()
    {
        $messages = Contact::orderByDesc('id')->limit(200)->get();
        return view('admin.messages', compact('messages'));
    }
}

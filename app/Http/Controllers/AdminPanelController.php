<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusMail;
use App\Models\Contact;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $stats = [
            'menu_total'    => MenuItem::count(),
            'menu_active'   => MenuItem::where('available', true)->count(),
            'orders_total'  => Order::count(),
            'orders_pending'=> Order::where('status', 'pending')->count(),
            'messages'      => Contact::count(),
        ];
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
        if (in_array($filter, ['pending', 'completed', 'cancelled'])) {
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

        $emailNote = '';
        if ($order->customer_email && ($previousStatus !== $order->status || $request->admin_message)) {
            try {
                Mail::to($order->customer_email)->send(new OrderStatusMail($order, 'status_change'));
                $emailNote = " Email sent to {$order->customer_email}.";
            } catch (\Throwable $e) {
                Log::warning("Admin email send failed for order #{$order->id}: " . $e->getMessage());
                $emailNote = ' (Email could not be sent — check SMTP config.)';
            }
        }

        return back()->with('ok', "Order #$id updated to {$request->status}.{$emailNote}");
    }

    public function ordersJson(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $q = Order::orderByDesc('id');
        if (in_array($filter, ['pending', 'completed', 'cancelled'])) {
            $q->where('status', $filter);
        }
        return response()->json([
            'orders' => $q->limit(100)->get(),
            'pending_count' => Order::where('status', 'pending')->count(),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    // ----- MESSAGES -----
    public function messagesIndex()
    {
        $messages = Contact::orderByDesc('id')->limit(200)->get();
        return view('admin.messages', compact('messages'));
    }
}

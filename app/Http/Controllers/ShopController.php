<?php

namespace App\Http\Controllers;

use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    // Admin panel — show settings page
    public function index()
    {
        $shop = ShopSetting::instance();
        return view('admin.shop', compact('shop'));
    }

    // Admin panel — save settings
    public function update(Request $request)
    {
        $data = $request->validate([
            'is_open'        => 'nullable|boolean',
            'use_schedule'   => 'nullable|boolean',
            'opening_time'   => 'required|string',
            'closing_time'   => 'required|string',
            'custom_message' => 'nullable|string|max:300',
        ]);

        $data['is_open']      = $request->boolean('is_open');
        $data['use_schedule'] = $request->boolean('use_schedule');

        $shop = ShopSetting::instance();
        $shop->update($data);

        Cache::forget('shop_status');

        return back()->with('ok', 'Shop settings updated successfully.');
    }

    // Public API — Flutter polls this
    public function apiStatus()
    {
        $status = Cache::remember('shop_status', 30, function () {
            $shop = ShopSetting::instance();
            $open = $shop->effectivelyOpen();
            return [
                'is_open'        => $open,
                'use_schedule'   => $shop->use_schedule,
                'opening_time'   => $shop->opening_time,
                'closing_time'   => $shop->closing_time,
                'custom_message' => $open ? null : ($shop->custom_message ?: 'Shop is currently closed. Please check back later.'),
            ];
        });

        return response()->json($status);
    }
}

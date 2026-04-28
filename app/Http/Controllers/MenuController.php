<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::orderBy('sort_order')->orderBy('id')->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'item_id'              => 'required|string|unique:menu_items,item_id',
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
            'price'                => 'required|numeric|min:0',
            'category'             => 'required|string|max:100',
            'emoji'                => 'nullable|string|max:10',
            'image_url'            => 'nullable|string|max:500',
            'available'            => 'boolean',
            'availability_message' => 'nullable|string|max:255',
        ]);

        $item = MenuItem::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $item = MenuItem::findOrFail($id);

        $request->validate([
            'name'                 => 'sometimes|string|max:255',
            'description'          => 'nullable|string',
            'price'                => 'sometimes|numeric|min:0',
            'category'             => 'sometimes|string|max:100',
            'emoji'                => 'nullable|string|max:10',
            'image_url'            => 'nullable|string|max:500',
            'available'            => 'sometimes|boolean',
            'availability_message' => 'nullable|string|max:255',
        ]);

        $item->update($request->all());
        return response()->json($item);
    }

    public function toggleAvailability(Request $request, $id)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $item = MenuItem::findOrFail($id);
        $item->available = !$item->available;
        $item->save();

        return response()->json($item);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->header('X-Admin-Key') !== config('app.admin_key', 'haji-admin-2024')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        MenuItem::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

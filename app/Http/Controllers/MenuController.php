<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $categories = Category::where('restaurant_id', $restaurant->id)
            ->with('menuItems')
            ->orderBy('sort_order')
            ->get();

        return view('dashboard.menu', compact('categories', 'restaurant'));
    }

    public function storeCategory(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        Category::create([
            'restaurant_id' => $restaurant->id,
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?? null,
            'sort_order' => Category::where('restaurant_id', $restaurant->id)->max('sort_order') + 1,
        ]);

        return redirect()->route('menu.index')->with('success', 'Category created successfully.');
    }

    public function storeItem(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:1',
        ]);

        MenuItem::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'preparation_time' => $validated['preparation_time'] ?? 15,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu item added successfully.');
    }

    public function toggleItem(MenuItem $item)
    {
        if ($item->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $item->update(['is_available' => !$item->is_available]);

        return redirect()->route('menu.index')->with('success', 'Item availability updated.');
    }

    public function destroyItem(MenuItem $item)
    {
        if ($item->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('menu.index')->with('success', 'Menu item deleted.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('menu.index')->with('success', 'Category deleted.');
    }
}

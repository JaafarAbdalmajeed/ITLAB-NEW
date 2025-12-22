<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavbarItem;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function index()
    {
        $items = NavbarItem::ordered()->get();
        return view('admin.navbar.index', compact('items'));
    }

    public function create()
    {
        return view('admin.navbar.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'nullable|string|in:_self,_blank',
            'css_class' => 'nullable|string|max:255',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';

        NavbarItem::create($data);

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item created successfully.');
    }

    public function edit(NavbarItem $navbar)
    {
        return view('admin.navbar.edit', compact('navbar'));
    }

    public function update(Request $request, NavbarItem $navbar)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'nullable|string|in:_self,_blank',
            'css_class' => 'nullable|string|max:255',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';

        $navbar->update($data);

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item updated successfully.');
    }

    public function destroy(NavbarItem $navbar)
    {
        $navbar->delete();

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item deleted successfully.');
    }

    /**
     * Update order of navbar items
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:navbar_items,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->input('items') as $item) {
            NavbarItem::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
    }
}

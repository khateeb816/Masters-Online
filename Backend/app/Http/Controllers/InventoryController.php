<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Notification;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('pages.inventories.index', compact('inventories'));
    }
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('pages.inventories.create', compact('categories', 'brands'));
    }
    public function store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'nullable',
            'brand_id' => 'required',
            'price' => 'required',
            'discounted_price' => 'nullable',
            'stock_quantity' => 'required',
            'status' => 'required',
            'images' => 'nullable|array',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Use microtime and index to ensure unique names
                $imageName = "inventory_" . microtime(true) . "_" . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $images[] = $imageName;
            }
        }

        $inventory = Inventory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'stock_quantity' => $request->stock_quantity,
            'status' => $request->status,
            'images' => !empty($images) ? json_encode($images) : null,
        ]);

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Inventory Created',
            'message' => 'Inventory ' . $inventory->name . ' created successfully',
            'type' => 'success',
            'icon' => 'fa-plus-circle',
        ]);

        return redirect()->route('inventories')->with('success', 'Inventory created successfully');
    }
    public function show($id)
    {
        $inventory = Inventory::with(['category', 'brand', 'reviews.user', 'orderDetails', 'wishLists'])->find($id);
        return view('pages.inventories.show', compact('inventory'));
    }
    public function edit($id)
    {
        $inventory = Inventory::find($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('pages.inventories.edit', compact('inventory', 'categories', 'brands'));
    }
    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'nullable',
            'brand_id' => 'required',
            'price' => 'required',
            'discounted_price' => 'nullable',
            'stock_quantity' => 'required',
            'status' => 'required',
            'images' => 'nullable|array',
        ]);

        // Start with existing images
        $images = [];
        if ($inventory->images) {
            $existingImages = json_decode($inventory->images, true);
            if (is_array($existingImages)) {
                $images = $existingImages;
            }
        }

        // Add new images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Use microtime and index to ensure unique names
                $imageName = "inventory_" . microtime(true) . "_" . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $images[] = $imageName;
            }
        }

        $inventory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'stock_quantity' => $request->stock_quantity,
            'status' => $request->status,
            'images' => !empty($images) ? json_encode($images) : null,
        ]);

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Inventory Updated',
            'message' => 'Inventory ' . $inventory->name . ' updated successfully',
            'type' => 'success',
            'icon' => 'fa-edit',
        ]);

        return redirect()->route('inventories')->with('success', 'Inventory updated successfully');
    }
    public function delete($id)
    {
        $inventory = Inventory::find($id);
        if ($inventory->images) {
            $existingImages = json_decode($inventory->images, true);
            if (is_array($existingImages)) {
                foreach ($existingImages as $image) {
                    unlink(public_path('uploads/' . $image));
                }
            }
        }
        $inventory->delete();

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Inventory Deleted',
            'message' => 'Inventory ' . $inventory->name . ' deleted successfully',
            'type' => 'success',
            'icon' => 'fa-trash',
        ]);

        return redirect()->route('inventories')->with('success', 'Inventory deleted successfully');
    }
}

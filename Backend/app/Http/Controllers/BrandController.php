<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Notification;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('pages.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('pages.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'brand_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status != null ? 'active' : 'inactive',
            'image' => $imageName ?? null,
        ]);


        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Brand Created',
            'message' => 'Brand ' . $brand->name . ' created successfully',
            'type' => 'success',
            'icon' => 'fa-plus-circle',
        ]);

        return redirect()->route('brands')->with('success', 'Brand created successfully');
    }
    public function show($id)
    {
        $brand = Brand::find($id);
        return view('pages.brands.show', compact('brand'));
    }
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('pages.brands.edit', compact('brand'));
    }
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found');
        }

        // Validate the request
        $request->validate([
            'name' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // Update user fields if not null
        $brandData = [];

        if ($request->filled('name')) {
            $brandData['name'] = $request->name;
        }

        if ($request->filled('description')) {
            $brandData['description'] = $request->description;
        }

        if ($request->filled('status')) {
            $brandData['status'] = $request->status;
        }

        if ($request->filled('image')) {
            $brandData['image'] = $request->image;
        }


        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'brand_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $brandData['image'] = $imageName;
        }

        // Update category if there are changes
        if (!empty($brandData)) {
            $brand->update($brandData);
        }



        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Brand Updated',
            'message' => 'Brand ' . $brand->name . ' updated successfully',
            'type' => 'success',
            'icon' => 'fa-edit',
        ]);

        return redirect()->route('brands')->with('success', 'Brand updated successfully');
    }
    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand->image) {
            unlink(public_path('uploads/' . $brand->image));
        }
        $brand->delete();

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Brand Deleted',
            'message' => 'Brand ' . $brand->name . ' deleted successfully',
            'type' => 'success',
            'icon' => 'fa-trash',
        ]);

        return redirect()->route('brands')->with('success', 'Brand deleted successfully');
    }
}

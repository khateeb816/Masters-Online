<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'category_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        $category = Category::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status != null ? 'active' : 'inactive',
            'image' => $imageName ?? null,
        ]);


        return redirect()->route('categories')->with('success', 'Category created successfully');
    }
    public function show($id)
    {
        $category = Category::find($id);
        return view('pages.categories.show', compact('category'));
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        // Validate the request
        $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // Update user fields if not null
        $categoryData = [];

        if ($request->filled('title')) {
            $categoryData['title'] = $request->title;
        }

            if ($request->filled('description')) {
                $categoryData['description'] = $request->description;
            }

        if ($request->filled('status')) {
            $categoryData['status'] = $request->status;
        }

        if ($request->filled('image')) {
            $categoryData['image'] = $request->image;
        }


        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'category_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $categoryData['image'] = $imageName;
        }

        // Update category if there are changes
        if (!empty($categoryData)) {
            $category->update($categoryData);
        }



        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->image) {
            unlink(public_path('uploads/' . $category->image));
        }
        $category->delete();
        return redirect()->route('categories')->with('success', 'Category deleted successfully');
    }
}

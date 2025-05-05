<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::with('parent')->orderBy('id', 'DESC')->paginate(50);
        return view('dashboard.categories', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/categories', $fileName);
            $category->image = $fileName;
        }

        $category->save();

        return redirect()->route('dashboard.categories')->with('success', 'Category created successfully!');
    }
    public function index()
    {
        $categories = Category::with('parent')->orderBy('id', 'DESC')->paginate(50);
        return view('dashboard.categories', compact('categories'));
    }
    
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('dashboard.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug,' . $id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            if ($category->image && Storage::exists('public/images/categories/' . $category->image)) {
                Storage::delete('public/images/categories/' . $category->image);
            }

            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/categories', $fileName);
            $category->image = $fileName;
        }

        $category->save();

        return redirect()->route('dashboard.categories')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with subcategories!');
        }

        // Delete image if exists
        if ($category->image && Storage::exists('public/images/categories/' . $category->image)) {
            Storage::delete('public/images/categories/' . $category->image);
        }

        $category->delete();

        return redirect()->route('dashboard.categories')->with('success', 'Category deleted successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Category::where('parent_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}

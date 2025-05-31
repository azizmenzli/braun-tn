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
 
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully!');
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

        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully!');
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

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Category::where('parent_id', $categoryId)->get();
        return response()->json($subcategories);
    }
    
    /**
     * Generate SEO metadata for a category
     * This is used by the ProductController when showing category pages
     */
    public static function generateCategorySeoMetadata(Category $category, $products = null)
    {
        // Generate SEO title if not set
        if (empty($category->meta_title)) {
            $category->meta_title = $category->name . ' - Produits Braun en Tunisie | Prix et Disponibilité';
        }
        
        // Generate SEO description if not set
        if (empty($category->meta_description)) {
            $category->meta_description = 'Découvrez notre gamme de produits Braun ' . $category->name . ' en Tunisie. ' .
                'Qualité garantie, prix compétitifs et livraison disponible partout en Tunisie.';
        }
        
        // Generate SEO keywords if not set
        if (empty($category->meta_keywords)) {
            $keywords = [
                $category->name,
                'Braun',
                'Tunisie',
                'prix',
                'acheter',
            ];
            
            // Add product names as keywords if products are provided
            if ($products && $products->count() > 0) {
                foreach ($products->take(5) as $product) {
                    $keywords[] = $product->name;
                    
                    // Extract model numbers and specific terms from product names
                    $nameParts = explode(' ', $product->name);
                    foreach ($nameParts as $part) {
                        if (preg_match('/^[a-zA-Z]+-[a-zA-Z0-9]+$/', $part) || // Match patterns like "Silk-epil"
                            (is_numeric($part) && strlen($part) < 5)) { // Match model numbers
                            $keywords[] = $part;
                        }
                    }
                }
            }
            
            $category->meta_keywords = implode(', ', array_unique(array_filter($keywords)));
        }
        
        return $category;
    }
}

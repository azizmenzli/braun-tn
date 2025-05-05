<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;           
class ProductController extends Controller
{

    public function add_product()
    {
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
    
        return view('dashboard.ajouter-produits', compact('categories'));
    }

    
    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'sku' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'regular_price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'sous_categorie_id' => 'nullable|numeric',
        'status' => 'required|in:published,draft',
        'type' => 'required|in:simple,variable',
        'additional_links' => 'nullable|string',
        'specifications' => 'nullable|array',
        'specifications.*.name' => 'required_with:specifications|string|max:255',
        'specifications.*.icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'quantity' => 'required|integer|min:0', 
    ]);

    // Create new product instance
    $product = new Product();
    $product->fill($validated);

    // Generate slug from name
    $product->slug = Str::slug($request->name);

    // Handle additional links
    if ($request->additional_links) {
        $links = collect(explode(',', $request->additional_links))
            ->map(fn($link) => ['url' => trim($link)])
            ->toArray();
        $product->additional_links = json_encode($links);
    }

    // Handle specifications with file uploads
    if ($request->specifications) {
        $specs = [];
        
        foreach ($request->specifications as $index => $specification) {
            if (!empty($specification['name'])) {
                $specData = ['name' => $specification['name']];

                if ($request->hasFile("specifications.$index.icon")) {
                    $iconPath = $request->file("specifications.$index.icon")->store('specification-icons', 'public');
                    $specData['icon'] = $iconPath;
                }

                $specs[] = $specData;
            }
        }

        $product->specifications = !empty($specs) ? json_encode($specs) : null;
    }

    // Set default stock status
    $product->stock_status = 'instock';

    // Set order value
    $product->order = Product::max('order') + 1;

    // Save the product
    $product->save();

    return redirect()
        ->route('produits')
        ->with('success', 'Produit ajouté avec succès !');
}

    








public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'sku' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'regular_price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'sous_categorie_id' => 'nullable|numeric',
        'status' => 'required|in:published,draft',
        'type' => 'required|in:simple,variable',
        'additional_links' => 'nullable|string',
        'specifications' => 'nullable|array',
        'specifications.*.name' => 'required_with:specifications|string|max:255',
        'specifications.*.icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'quantity' => 'required|integer|min:0', 
    ]);

    $product->fill($validated);
    $product->slug = Str::slug($request->name);

    if ($request->additional_links) {
        $links = collect(explode(',', $request->additional_links))
            ->map(fn($link) => ['url' => trim($link)])
            ->toArray();
        $product->additional_links = json_encode($links);
    }

    if ($request->specifications) {
        $specs = [];
        foreach ($request->specifications as $index => $specification) {
            if (!empty($specification['name'])) {
                $specData = ['name' => $specification['name']];

                if ($request->hasFile("specifications.$index.icon")) {
                    $iconPath = $request->file("specifications.$index.icon")->store('specification-icons', 'public');
                    $specData['icon'] = $iconPath;
                }

                $specs[] = $specData;
            }
        }

        $product->specifications = !empty($specs) ? json_encode($specs) : null;
    }

    $product->save();

    return redirect()
        ->route('produits')
        ->with('success', 'Produit modifié avec succès !');
}


public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Optionnel : supprimer les fichiers d'icônes associés
    if ($product->specifications) {
        $specs = json_decode($product->specifications, true);
        foreach ($specs as $spec) {
            if (isset($spec['icon']) && Storage::disk('public')->exists($spec['icon'])) {
                Storage::disk('public')->delete($spec['icon']);
            }
        }
    }

    $product->delete();

    return redirect()
        ->route('produits')
        ->with('success', 'Produit supprimé avec succès !');
}













 
  public function validateSku(Request $request)
    {
        // Valider le SKU avec l'option 'unique' sur la table products
        $validator = Validator::make($request->all(), [
            'SKU' => 'required|unique:products,SKU',  // Vérifie si le SKU est unique
        ]);
    
        if ($validator->fails()) {
            // Si la validation échoue, renvoyer un JSON avec valid = false
            return response()->json(['valid' => false]);
        }
    
        // Si la validation réussit, renvoyer valid = true
        return response()->json(['valid' => true]);
    }
     
 
    
     
    public function index()
{
    // Récupérer tous les produits, ou vous pouvez appliquer un filtrage, tri, pagination, etc.
    $products = Product::paginate(10); 

    // Retourner la vue avec les produits
    return view('dashboard.produits', compact('products'));
}
 
  
public function show($id)
{
    // Récupération du produit principal
    $product = Product::findOrFail($id);

    // Récupération des produits similaires
    $similarProducts = Product::select([
            'p.id as product_id', 
            'p.name as product_name', 
            'p.regular_price', 
            'p.sale_price',   
            'c1.id as category_id', 
            'c1.name as category_name', 
            'c2.id as sub_category_id', 
            'c2.name as sub_category_name'
        ])
        ->from('products as p')
        ->join('categories as c1', 'p.category_id', '=', 'c1.id')
        ->leftJoin('categories as c2', 'p.sous_categorie_id', '=', 'c2.id')
        ->where('p.id', '!=', $product->id)
        ->where('c1.id', $product->category_id)
        ->where(function ($query) use ($product) {
            $query->where('c2.id', $product->sous_categorie_id)
                  ->orWhereNull('c2.id');
        })
        ->orderBy('c1.name')
        ->orderBy('c2.name')
        ->orderBy('p.name')
        ->limit(4)
        ->get();

    // Retour de la vue avec les données
    return view('produit', [
        'product' => $product,
        'similarProducts' => $similarProducts
    ]);
}


public function showCategoryAndSubCategoryProducts($categoryId, Request $request)
{
    // Récupérer la catégorie principale
    $category = Category::findOrFail($categoryId);

    // Récupérer les sous-catégories associées à cette catégorie
    $subCategories = $category->subCategories;

    // Obtenir le sous-catégorie ID de la requête
    $subCategoryId = $request->input('subCategoryId');

    // Créer la requête de base pour récupérer les produits de la catégorie principale
    $productsQuery = Product::where('category_id', $categoryId);

    // Si un ID de sous-catégorie est fourni, on ajoute la condition de sous-catégorie
    if ($subCategoryId) {
        $productsQuery->where('sous_categorie_id', $subCategoryId);
    }

    // Trier les produits en fonction du paramètre sort_by (si nécessaire)
    $sort_by = $request->input('sort_by', 'featured');
    switch ($sort_by) {
        case 'price-low-high':
            $productsQuery->orderBy('regular_price', 'asc');
            break;
        case 'price-high-low':
            $productsQuery->orderBy('regular_price', 'desc');
            break;
        case 'a-z':
            $productsQuery->orderBy('name', 'asc');
            break;
        case 'z-a':
            $productsQuery->orderBy('name', 'desc');
            break;
        default:
            $productsQuery->orderBy('created_at', 'desc');
            break;
    }

    // Récupérer les produits filtrés ou paginés
    $products = $productsQuery->paginate(48);

    // Retourner la vue avec les données nécessaires
    return view('categorie', compact('category', 'subCategories', 'products', 'sort_by'));
}

}
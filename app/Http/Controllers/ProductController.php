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


    public function boot()
    {
        Carbon::setLocale('fr');
        App::setLocale('fr');
    }

    public function add_product()
    {
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
    
        return view('dashboard.ajouter-produits', compact('categories'));
    }

    public function store(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'SKU' => 'required|string|max:255',
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
    
        // Création du produit
        $product = new Product();
        $product->fill($validated);
    
        // Générer le slug à partir du nom
        $product->slug = Str::slug($validated['name']);
    
        // Liens additionnels formatés
        if ($request->additional_links) {
            $links = collect(explode(',', $request->additional_links))
                ->map(fn($link) => ['url' => trim($link)])
                ->toArray();
            $product->additional_links = json_encode($links);
        }
    
        // Spécifications (avec upload d'icône)
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
    
        // Stock par défaut
        $product->stock_status = 'instock';
    
        // Définir l'ordre d'affichage
        #$product->order = Product::max('order') + 1;
    
        // Enregistrer
        $product->save();
    
        return redirect()
            ->route('dashboard.produits.index')
            ->with('success', 'Produit ajouté avec succès !');
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
    // Récupérer les paramètres de filtre
    $stockFilter = request()->input('stock_filter');
    $searchTerm = request()->input('search');
    
    // Construire la requête de base
    $query = Product::query();
    
    // Appliquer le filtre de stock si sélectionné
    if ($stockFilter === 'low_stock') {
        $query->where('quantity', '<', 10);
    } elseif ($stockFilter === 'out_of_stock') {
        $query->where('quantity', '<=', 0);
    }
    
    // Appliquer la recherche si un terme est fourni
    if ($searchTerm) {
        $query->where('name', 'like', '%'.$searchTerm.'%')
              ->orWhere('SKU', 'like', '%'.$searchTerm.'%');
    }
    
    // Paginer les résultats
    $products = $query->paginate(5);
    
    // Retourner la vue avec les produits
    return view('dashboard.produits', compact('products'));
}







 
public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Supprimer les fichiers d'icône liés aux spécifications (si existants)
    if ($product->specifications) {
        $specs = json_decode($product->specifications, true);
        foreach ($specs as $spec) {
            if (isset($spec['icon'])) {
                Storage::disk('public')->delete($spec['icon']);
            }
        }
    }

    // Supprimer le produit
    $product->delete();

    return redirect()->route('dashboard.produits.index')->with('success', 'Produit supprimé avec succès.');
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
    $productsQuery = Product::where('category_id', $categoryId)
                            ->where('quantity', '>', 0); // Filtrer les produits en stock uniquement

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
            $productsQuery->orderBy('created_at', 'asc');
            break;
    }

    // Récupérer les produits filtrés ou paginés
    $products = $productsQuery->orderBy('sale_price', 'asc')->paginate(48);

   
    // Retourner la vue avec les données nécessaires
    return view('categorie', compact('category', 'subCategories', 'products', 'sort_by'));
}




 
public function update(Request $request, $id)
{
    try {
    $validated = $request->validate([
            'name' => 'required|string|max:255',
        'SKU' => 'required|string|max:255',
        'description' => 'required|string',
        'regular_price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:published,draft',
        'type' => 'required|in:simple,variable',
            'quantity' => 'required|integer|min:0',
            'image_links' => 'nullable|string',
        'specifications.*.name' => 'required_with:specifications|string|max:255',
            'specifications.*.icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

        $product = Product::findOrFail($id);
        
        // Mise à jour des champs de base
    $product->fill($validated);
    $product->slug = Str::slug($validated['name']);

        // Gestion des liens d'images
        if ($request->has('image_links')) {
            $links = collect(explode(',', $request->image_links))
                ->map(function($link) {
                    return ['url' => trim($link)];
                })
                ->filter(function($link) {
                    return !empty($link['url']);
                })
                ->values()
            ->toArray();
            
        $product->additional_links = json_encode($links);
    }

        // Gestion des spécifications
        if ($request->has('specifications')) {
        $specs = [];
        foreach ($request->specifications as $index => $specification) {
                $specData = ['name' => $specification['name']];

                if (isset($specification['icon']) && $specification['icon']) {
                    $iconPath = $specification['icon']->store('specifications', 'public');
                    $specData['icon'] = $iconPath;
                } elseif (isset($product->specifications[$index]['icon'])) {
                    $specData['icon'] = $product->specifications[$index]['icon'];
                }

                $specs[] = $specData;
            }
            $product->specifications = json_encode($specs);
    }

    $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Produit modifié avec succès'
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur de validation: ' . implode(', ', $e->errors())
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la modification du produit: ' . $e->getMessage()
        ], 500);
    }
}



// Exemple dans le contrôleur
public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::whereNull('parent_id')->orderBy('name')->get();
    return view('dashboard.edit-product', compact('product', 'categories'));
}


public static function getNotifications()
{
    $lowStockThreshold = 5;

    $lowStockProducts = Product::where('quantity', '>', 0)
        ->where('quantity', '<=', $lowStockThreshold)
        ->get();

    $outOfStockProducts = Product::where('quantity', '=', 0)->get();

    return [
        'low_stock' => $lowStockProducts,
        'out_of_stock' => $outOfStockProducts,
    ];
}









}
<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribut;
use App\Models\Slide;
use App\Models\Order;
use App\Models\user;
use Illuminate\Support\Facades\Hash; // Importez cette ligne
use App\Models\Coupon;
use App\Models\Demande_revendeur;
use Illuminate\Support\Str;   
use Carbon\Carbon;           
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;  
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\VisitorLog;
 use Jenssegers\Agent\Agent;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Password;
 use App\Mail\ClientOrderMail; // Mail pour le client
 use App\Mail\AdminOrderMail; // Mail pour le client
 use Illuminate\Support\Facades\Mail;
 use ArielMejiaDev\LarapexCharts\LarapexChart;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  /*  public function index()
    {
        return view('admin.dashboard'); // Return the view for the admin dashboard
    }
   */


   /*Categories */

    public function categories()
 {
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view("dashboard.categories",compact('categories'));
        
 }


 public function add_category()
 {
     return view("dashboard.categories");
 }


 public function add_category_store(Request $request)
 {
     // Validation des données
     $request->validate([
         'name' => 'required',
         'slug' => 'required|unique:categories,slug',
         'image' => 'nullable|mimes:png,jpg,jpeg|max:2048', // Validation de l'image
         'parent_id' => 'nullable|exists:categories,id', // Validation du parent_id
     ]);
 
     // Création d'une nouvelle catégorie
     $category = new Category();
     $category->name = $request->name;
     $category->slug = Str::slug($request->name); // Génération du slug
 
     // Vérification du parent_id
     if ($request->parent_id) {
         $category->parent_id = $request->parent_id;
     }
 
     // Traitement de l'image
     if ($request->hasFile('image')) {
         $image = $request->file('image');
         $fileExtension = $image->extension(); // Extension du fichier
         $fileName = Carbon::now()->timestamp . '.' . $fileExtension; // Nom du fichier avec timestamp
 
         // Enregistrement de l'image
         $imagePath = $image->storeAs('images/categories', $fileName, 'public');
 
         // Stocker le nom de l'image dans la base de données
         $category->image = $fileName;
     }
 
     // Sauvegarde de la catégorie dans la base de données
     $category->save();
 
     // Redirection avec message de succès
     return redirect()->route('dashboard.categories')->with('status', 'Category has been added successfully!');
 }
 
 public function addCategory()
 {
     // Récupérer toutes les catégories (ou vous pouvez filtrer selon votre besoin)
     $categories = Category::all();
 
     // Passer la variable 'categories' à la vue
     return view('dashboard.categories', compact('categories'));
 }
 public function create()
{
    $categories = Category::all(); // ou un autre filtre si nécessaire
    return view('dashboard.category.create', compact('categories'));
}


public function edit_category($id)
{
    $category = Category::find($id);
    return view('dashboard.category-edit',compact('category'));
}

public function update_category(Request $request)
{
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:categories,slug,' . $request->id,
        'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
    ]);

    $category = Category::find($request->id);
    $category->name = $request->name;
    $category->slug = $request->slug;

    // Vérification et traitement de l'image
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image
        if (File::exists(public_path('images/categories') . '/' . $category->image)) {
            File::delete(public_path('images/categories') . '/' . $category->image);
        }

        // Enregistrer la nouvelle image
        $image = $request->file('image');
        $fileExtension = $image->extension();
        $fileName = Carbon::now()->timestamp . '.' . $fileExtension;

        // Enregistrer l'image dans le dossier public/images/categories
        $image->storeAs('images/categories', $fileName, 'public');

        // Mettre à jour le nom de l'image dans la base de données
        $category->image = $fileName;
    }

    // Sauvegarde de la catégorie mise à jour dans la base de données
    $category->save();

    // Redirection avec message de succès
    return redirect()->route('dashboard.categories')->with('status', 'Record has been updated successfully!');
}


public function delete_category($id)
{
    $category = Category::find($id);
    if (File::exists(public_path('images/categories').'/'.$category->image)) {
        File::delete(public_path('images/categories').'/'.$category->image);
    }
    $category->delete();
    return redirect()->route('admin.categories')->with('status','Record has been deleted successfully !');
}




// CategoryController.php
public function getSubcategories($categoryId)
{
    // Récupérer les sous-catégories pour une catégorie donnée
    $subcategories = Category::where('parent_id', $categoryId)->get();

    // Vérifier s'il y a des sous-catégories
    if ($subcategories->isEmpty()) {
        return response()->json([], 200); // Retourner un tableau vide si aucune sous-catégorie
    }

    // Retourner les sous-catégories en réponse JSON
    return response()->json($subcategories, 200);
}



/*Porduits */

public function add_product()
{
    $categories = Category::whereNull('parent_id')->orderBy('name')->get();
    $attributes = Attribut::all(); // Récupérer tous les attributs disponibles

    return view('admin.product-add', compact('categories', 'attributes'));
}
public function product_store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:products,slug',
        'category_id' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'regular_price' => 'required_if:Type,simple',
        'sale_price' => 'nullable',
        'SKU' => 'required|unique:products,SKU',
        'stock_status' => 'required',
        'featured' => 'required',
        'quantity' => 'required_if:Type,simple',
        'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        'sous_categorie_id' => 'nullable|exists:categories,id',
        'attribut_id' => 'nullable|integer|exists:attributs,id',
        'value_attribut' => 'nullable|array', // Ensure value_attribut is an array
        'value_attribut.*' => 'nullable|string', // Validate each value in the array
        'Publié' => 'nullable|boolean',
        'Type' => 'required|in:simple,variable', // Ensure Type is required
        'order' => 'nullable|integer', // Ajouter la validation pour `order`
    ]);

    // Additional validation for variable products
    if ($request->Type === 'variable') {
        $request->validate([
            'attribut_id' => 'required|integer|exists:attributs,id',
            'value_attribut' => 'required|array',
            'value_attribut.*' => 'required|string'
        ]);
    }

    $product = new Product();
    $product->fill($request->except(['image', 'images']));
    $product->slug = Str::slug($request->name);
    $product->Publié = $request->Publié;
    $product->Type = $request->Type ?? 'simple';

    // Handle attribut_id and value_attribut for variable products
    if ($request->Type === 'variable') {
        $product->attribut_id = $request->attribut_id;
        $product->value_attribut = json_encode($request->value_attribut); // Store as JSON
    } else {
        $product->attribut_id = null;
        $product->value_attribut = null;
    }

    // Définir l'ordre du produit
    if ($request->has('order') && $request->order !== null) {
        $product->order = $request->order; // Utiliser l'ordre fourni par l'utilisateur
    } else {
        // Récupérer l'ordre du dernier produit ajouté
        $lastProduct = Product::orderBy('order', 'desc')->first();
        $product->order = $lastProduct ? $lastProduct->order + 1 : 1; // Incrémenter l'ordre
    }

    $current_timestamp = Carbon::now()->timestamp;

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $current_timestamp . '.' . $image->extension();
        $image->move(public_path('uploads/products'), $imageName);
        $product->image = $imageName;
    }

    // Handle gallery images
    if ($request->hasFile('images')) {
        $gallery_arr = [];
        foreach ($request->file('images') as $file) {
            $imageName = $current_timestamp . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $imageName);
            $gallery_arr[] = $imageName;
        }
        $product->images = json_encode($gallery_arr);
    }

    $product->save();

    return redirect()->route('admin.products')->with('status', 'Produit ajouté avec succès !');
}

public function updateOrder(Request $request)
{
    // Valider la requête
    $request->validate([
        'order' => 'required|array', // Vérifier que `order` est un tableau
    ]);

    // Récupérer l'ordre des IDs
    $order = $request->input('order');

    // Mettre à jour l'ordre de chaque produit
    foreach ($order as $index => $productId) {
        DB::table('products')
            ->where('id', $productId)
            ->update(['order' => $index + 1]); // Mettre à jour la colonne `order`
    }

    // Retourner une réponse JSON
    return response()->json([
        'success' => true,
        'message' => 'Ordre mis à jour avec succès !',
    ]);
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

public function getValues($id)
{
    $attribut = Attribut::find($id);
    
    if ($attribut) {
        $values = explode(',', $attribut->value); // Convertit la chaîne de valeurs séparées par des virgules en tableau
        return response()->json([
            'values' => array_map(function($value) {
                return ['id' => $value, 'nom' => $value]; // Modifiez selon la structure de vos valeurs
            }, $values)
        ]);
    }
    
    return response()->json(['values' => []]); // Retourne un tableau vide si l'attribut n'existe pas
}

public function update_product(Request $request)
{
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:products,slug,' . $request->id,
        'category_id' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'regular_price' => 'required',
        'sale_price' => 'required',
        'SKU' => 'required',
        'stock_status' => 'required',
        'featured' => 'required',
        'quantity' => 'required',
        'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        'sous_categorie_id' => 'nullable|exists:categories,id',
        'Publié' => 'nullable|boolean',
        'Type' => 'nullable|string',
    ]);

    $product = Product::find($request->id);
    $product->name = $request->name;
    $product->slug = Str::slug($request->name);
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->regular_price = $request->regular_price;
    $product->sale_price = $request->sale_price;
    $product->SKU = $request->SKU;
    $product->stock_status = $request->stock_status;
    $product->featured = $request->featured;
    $product->quantity = $request->quantity;
    $slug = $product->slug; // Récupération du slug

    // **Traitement de l'image principale**
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $extension = $image->extension();
        $imageName = $slug . '.' . $extension;

        // Sauvegarde de l'image principale
        $image->move(public_path('uploads/products'), $imageName);

        // Création de la miniature
        $imagePath = public_path('uploads/products/' . $imageName);
        $thumbnailPath = public_path('uploads/products/thumbnails/' . $imageName);
        $command = "convert " . escapeshellarg($imagePath) . " -resize 150x150 " . escapeshellarg($thumbnailPath);
        exec($command);

        $product->image = $imageName;
    }

    // **Traitement des images de la galerie**
    $gallery_arr = [];
    $counter = 1;

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $extension = $file->getClientOriginalExtension();
            $galleryImageName = $slug . '-' . $counter . '.' . $extension;

            // Sauvegarde de l'image
            $file->move(public_path('uploads/products'), $galleryImageName);

            // Création de la miniature
            $imagePath = public_path('uploads/products/' . $galleryImageName);
            $thumbnailPath = public_path('uploads/products/thumbnails/' . $galleryImageName);
            $command = "convert " . escapeshellarg($imagePath) . " -resize 150x150 " . escapeshellarg($thumbnailPath);
            exec($command);

            $gallery_arr[] = $galleryImageName;
            $counter++;
        }
    }

    // Stockage des images sous forme de chaîne de caractères
    $product->images = implode(',', $gallery_arr);
    $product->category_id = $request->category_id;
    $product->sous_categorie_id = $request->sous_categorie_id;
    $product->Publié = $request->Publié ?? 1;
    $product->Type = $request->Type ?? 'simple';

    $product->save();

    return redirect()->route('admin.products')->with('status', 'Produit mis à jour avec succès !');
}



public function edit_product($id)
{
    $product = Product::find($id);
    $categories = Category::Select('id','name')->orderBy('name')->get();


    return view('admin.product-edit',compact('product','categories'));
}
 

public function products()
{
    $products = Product::with('attribut')->orderBy('created_at', 'DESC')->paginate(120);
    return view("admin.products", compact('products'));
}


public function coupons()
{
        $coupons = Coupon::orderBy("expiry_date","DESC")->paginate(12);
        return view("admin.coupons",compact("coupons"));
}
public function add_coupon()
{        
    return view("admin.coupon-add");
}
public function add_coupon_store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:coupons,code',
        'type' => 'required',
        'value' => 'required|numeric',
        'cart_value' => 'required|numeric',
        'ceiling' => 'nullable|numeric', // Validation pour le plafond
        'min_spend' => 'required|numeric', // Validation pour la dépense minimum
        'usage_limit_per_order' => 'nullable|integer|min:1', // Validation pour la limite par commande
        'usage_limit_per_user' => 'nullable|integer|min:1', // Validation pour la limite par utilisateur
        'start_date' => 'required|date|before:end_date', // Validation pour la date de début
        'end_date' => 'required|date|after:start_date', // Validation pour la date de fin
        'status' => 'required|in:active,inactive', // Validation pour le statut
    ]);

    $coupon = new Coupon();
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->cart_value = $request->cart_value;
    $coupon->ceiling = $request->ceiling;
    $coupon->min_spend = $request->min_spend;
    $coupon->usage_limit_per_order = $request->usage_limit_per_order;
    $coupon->usage_limit_per_user = $request->usage_limit_per_user;
    $coupon->start_date = $request->start_date;
    $coupon->end_date = $request->end_date;
    $coupon->status = $request->status;
    $coupon->save();

    return redirect()->route("admin.coupons")->with('status', 'Le coupon a été ajouté avec succès !');
}


public function edit_coupon($id)
{
       $coupon = Coupon::find($id);
       return view('admin.coupon-edit',compact('coupon'));
}

public function update_coupon(Request $request)
{
       $request->validate([
       'code' => 'required',
       'type' => 'required',
       'value' => 'required|numeric',
       'cart_value' => 'required|numeric',
       'expiry_date' => 'required|date'
       ]);

       $coupon = Coupon::find($request->id);
       $coupon->code = $request->code;
       $coupon->type = $request->type;
       $coupon->value = $request->value;
       $coupon->cart_value = $request->cart_value;
       $coupon->expiry_date = $request->expiry_date;               
       $coupon->save();           
       return redirect()->route('admin.coupons')->with('status','Record has been updated successfully !');
}


public function delete_coupon($id)
{
        $coupon = Coupon::find($id);        
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status','Record has been deleted successfully !');
}


public function apply_coupon_code(Request $request)
{        
    $coupon_code = $request->coupon_code;
    if(isset($coupon_code))
    {
        $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
        if(!$coupon)
        {
            return back()->with('error','Invalid coupon code!');
        }
        session()->put('coupon',[
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);
        $this->calculateDiscounts();
        return back()->with('status','Le code promo a été appliqué!');
    }
    else{
        return back()->with('error','Code promo invalide!');
    }        
}
public function calculateDiscounts()
{
    $discount = 0;
    if(session()->has('coupon'))
    {
        if(session()->get('coupon')['type'] == 'fixed')
        {
            $discount = session()->get('coupon')['value'];
        }
        else
        {
            $discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
        }

        $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax'))/100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount; 

        session()->put('discounts',[
            'discount' => number_format(floatval($discount),2,'.',''),
            'subtotal' => number_format(floatval(Cart::instance('cart')->subtotal() - $discount),2,'.',''),
            'tax' => number_format(floatval((($subtotalAfterDiscount * config('cart.tax'))/100)),2,'.',''),
            'total' => number_format(floatval($subtotalAfterDiscount + $taxAfterDiscount),2,'.','')
        ]);            
    }
}

public function orders()
{
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        return view("dashboard.commandes",compact('orders'));
}
public function order_items($order_id){
    $order = Order::find($order_id);
      $orderitems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
      $transaction = Transaction::where('order_id',$order_id)->first();


      return view("admin.order-details",compact('order','orderitems','transaction'));
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



    

 


public function addToCart(Request $request)
{
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1);

    // Ajouter le produit au panier (utiliser une session ou une base de données)
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = [
            'name' => 'Nom du produit',
            'price' => 25.00,
            'image' => 'url_de_l_image',
            'quantity' => $quantity,
        ];
    }

    session()->put('cart', $cart);

    return response()->json(['cart' => $cart]);
}

public function showCategoryProductsSlide()
{
    // Récupérer les 5 premiers produits pour chaque catégorie
    $categoryIds = [35, 10, 24]; // Exemple : ID de 3 catégories
    $products = [];

    foreach ($categoryIds as $id) {
        $categoryProducts = Product::where('category_id', $id)
                                    
                                    ->get();
        $products[$id] = $categoryProducts;
    }
    $slides = Slide::all(); // Récupère tous les slides depuis la base de données

    // Retourner la vue index avec les produits des trois catégories
    return view('index', compact('products','slides'));
}

//Revendeurs
public function indexDemandeRevendeur()
{
    $demandes = Demande_revendeur::all();
    return view('admin.contact', compact('demandes'));
}

public function updateDemandeRevendeur(Request $request)
{
    $request->validate([
        'id' => 'required|exists:demande_revendeur,id',
        'name' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string',
    ]);

    $demande = Demande_revendeur::findOrFail($request->id);
    $demande->update($request->all());

    return redirect()->back()->with('success', 'Demande mise à jour avec succès.');
}

public function destroyDemandeRevendeur($id)
{
    $demande = Demande_revendeur::findOrFail($id);
    $demande->delete();

    return redirect()->back()->with('success', 'Demande supprimée avec succès.');
}
 
//Slides



public function storeSlides(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'line1' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $imagePath = $request->file('image')->store('slides', 'public');

    Slide::create([
        'title' => $request->title,
        'line1' => $request->line1,
        'line2' => $request->line2,
        'image_path' => $imagePath,
        'type' => $request->category_icon,
    ]);

    return redirect()->back()->with('success', 'Slide added successfully!');
}
/*
public function indexSlideHome()
{
    $slides = Slide::all(); // Récupère tous les slides depuis la base de données
    return view('index', compact('slidesHome'));
}
*/


public function indexSlides()
{
    $slides = Slide::all();
    return view('admin.slides', compact('slides'));
}

public function editslide($id)
    {
        $slide = Slide::findOrFail($id);

        return view('admin.slides', compact('slide'));
    }

    // Méthode pour mettre à jour un slide
    public function updateslide(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_icon' => 'nullable|string',
        ]);

        $slide = Slide::findOrFail($id);

        // Mise à jour de l'image si présente
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slides', 'public');
            $slide->image_path = $imagePath;
        }

        // Mise à jour des autres données
        $slide->update([
            'title' => $validatedData['title'],
            'line1' => $validatedData['line1'],
            'line2' => $validatedData['line2'],
            'category_icon' => $validatedData['category_icon'] ?? $slide->category_icon,
        ]);

        return redirect()->route('admin.slides')->with('success', 'Slide mis à jour avec succès.');
    }

    // Méthode pour supprimer un slide
    public function destroyslide($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();

        return redirect()->route('admin.slides')->with('success', 'Slide supprimé avec succès.');
    }
  
    //Order  
    public function processOrder(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|regex:/^\+?[0-9]{8,8}$/',
            'adress' => 'required|string',
            'sex' => 'nullable|in:male,female,other',
            'date_naissance' => 'nullable|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:espace,carte',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Générer une référence unique pour la commande
        $redOrder = uniqid('ORD-');
    
        // Déterminer la source de la commande
        $sourceCommande = 'web';
    
        // Obtenir l'adresse IP et le type d'appareil du client
        $ipClient = $request->ip();
        $deviceClient = $this->detectDevice($request);
    
        $orders = [];
    
        foreach ($request->products as $product) {
            $produit = Product::find($product['product_id']);
    
            // Vérifier si le produit existe et est en stock
            if (!$produit) {
                return redirect()->back()->withInput()->with('error', "Le produit sélectionné n'existe pas.");
            }
    
            Log::info("Stock vérifié pour {$produit->name}, quantité en stock: {$produit->quantity}, demandée: {$product['quantity']}");
    
            if ($produit->quantity < $product['quantity']) {
                Log::error("Le produit {$produit->name} est en rupture de stock.");
                return redirect()->back()->withInput()->with('error', "Le produit {$produit->name} est en rupture de stock ou la quantité demandée dépasse le stock disponible.");
            }
    
            // Déduire la quantité du stock
            $produit->quantity -= $product['quantity'];
            $produit->save();
    
            // Création de la commande
            $order = new Order();
            $order->red_order = $redOrder;
            $order->nom = $request->nom;
            $order->prenom = $request->prenom;
            $order->email = $request->email;
            $order->telephone = $request->telephone;
            $order->adress = $request->adress;
            $order->sex = $request->sex;
            $order->date_naissance = $request->date_naissance;
            $order->date_order = now();
            $order->id_produit = $product['product_id'];
            $order->prix_produit = $product['price'];
            $order->quantite_produit = $product['quantity'];
            $order->mode_paiement = $request->mode_paiement;
            $order->source_commande = $sourceCommande;
            $order->ip_client = $ipClient;
            $order->device_client = $deviceClient;
            $order->save();
    
            $orders[] = $order;
        }
    
        // Envoi du mail de confirmation au client
        Mail::to($request->email)->send(new ClientOrderMail($orders));
    
        return redirect()->route('confirmation', ['redOrder' => $redOrder])
            ->with('success', 'Votre commande a été passée avec succès.');
    }
    
    public function checkoutSuccess()
    {
        return view('checkout');
    }
    
    public function showOrderConfirmation($redOrder)
    {
        // Récupérer tous les produits associés à la commande
        $orders = Order::where('red_order', $redOrder)->get();
    
        // Vérifier si la commande existe
        if ($orders->isEmpty()) {
            return redirect()->route('home')->with('error', 'Commande introuvable.');
        }
    
        // Passer les détails de la commande à la vue
        return view('confirmation', compact('orders'));
    }
    

    


    /**
     * Détecte le type d'appareil utilisé par le client
     *
     * @param Request $request
     * @return string
     */
    private function detectDevice(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        if (preg_match('/mobile/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
    
    
    // Afficher toutes les commandes
     

    // Afficher une commande spécifique
  
    // Créer une nouvelle commande
   /* public function indexOrder()
    {
        // Frais fixes
        $frais_livraison = 7;
        $frais_fiscal = 1;
    
        // Récupérer les commandes avec leurs produits associés
        $orders = DB::table('orders')
                    ->join('products', 'orders.id_produit', '=', 'products.id')
                    ->select(
                        'orders.id AS order_id',  
                        'orders.red_order',
                        'orders.nom',
                        'orders.prenom',
                        'orders.telephone',
                        'orders.email',
                        'orders.date_order',
                        'orders.status',
                        'orders.adress',
                        'orders.quantite_produit',
                        'orders.prix_produit',
                        'products.id AS product_id',  
                        'products.name AS product_name'
                    )
                    ->get();
    
        // Regrouper les commandes par 'red_order'
        $groupedOrders = $orders->groupBy('red_order');
    
        // Ajouter les totaux calculés pour chaque groupe
        foreach ($groupedOrders as $red_order => $ordersGroup) {
            // Initialiser le sous-total et le total pour chaque red_order
            $totalSubtotal = 0;
            $totalItems = 0;
    
            foreach ($ordersGroup as $order) {
                // Calculer le sous-total pour les produits dans chaque commande
                $subtotal = $order->prix_produit * $order->quantite_produit;
                $totalSubtotal += $subtotal;  // Ajouter au sous-total général du red_order
                $totalItems += $order->quantite_produit;  // Compter le nombre d'articles
    
                // Calcul du total avec les frais fixes pour chaque commande
                $total = $subtotal + $frais_livraison + $frais_fiscal;
                
                // Ajouter les résultats de calcul dans chaque commande
                $order->subtotal = $subtotal;
                $order->total = $total;
            }
    
            // Ajouter les totaux (frais inclus) au red_order
            $groupedOrders[$red_order]->totalSubtotal = $totalSubtotal + $frais_livraison + $frais_fiscal;
            $groupedOrders[$red_order]->totalItems = $totalItems;
        }
    
        // Passer les données à la vue
        return view('dashboard/commandes', compact('groupedOrders'));
    }*/
    

    
    
       
       
   
   // Mettre à jour le statut d'une commande
   public function updateStatusOrder(Request $request, $red_order)
   {
       // Valider les données
       $request->validate([
           'status' => 'required|string|in:pending,delivered,canceled', // Les statuts possibles
       ]);
   
       // Récupérer la commande spécifique par order_id
       $order = DB::table('orders')
                  ->where('red_order', $red_order)
                  ->first();
   
       // Vérifier si la commande existe
       if (!$order) {
           return redirect()->route('admin.orders')->with('error', 'Aucune commande trouvée avec cet ID.');
       }
   
       // Mettre à jour le statut de la commande
       DB::table('orders')
           ->where('red_order', $red_order)
           ->update(['status' => $request->status]);
   
       return redirect()->route('admin.orders')->with('success', 'Statut de la commande mis à jour.');
   }
   
   public function RechercheOrder(Request $request)
{
   
    // Retourner la vue avec les commandes filtrées
    return view('admin.orders', compact('groupedOrders'));
}


public function Dashbaordadmin()
{
    // Récupérer les statistiques globales
    $totalOrders = Order::distinct('red_order')->count('red_order');
    $totalAmount = Order::sum(DB::raw('prix_produit * quantite_produit'));

    // Statistiques par statut
    $statuses = ['pending', 'delivered', 'canceled'];
    $statusData = [];
    foreach ($statuses as $status) {
        $orders = Order::where('status', $status)->get();
        $totalSubtotal = 0;
        $totalItems = 0;

        foreach ($orders as $order) {
            $subtotal = $order->prix_produit * $order->quantite_produit;
            $totalSubtotal += $subtotal;
            $totalItems += $order->quantite_produit;
        }

        $statusData[$status] = [
            'order_count' => $orders->count(),
            'total_amount' => $totalSubtotal,
            'total_items' => $totalItems,
        ];
    }

    // Statistiques pour les modes de paiement
    $paymentData = Order::select('mode_paiement', DB::raw('COUNT(DISTINCT red_order) as count'))
        ->groupBy('mode_paiement')
        ->pluck('count', 'mode_paiement');

    // Statistiques pour les sources de commande
    $sourceData = Order::select('source_commande', DB::raw('COUNT(DISTINCT red_order) as count'))
        ->groupBy('source_commande')
        ->pluck('count', 'source_commande');

    // Données pour la carte des IP
    $ipData = Order::select('ip_client')
        ->distinct()
        ->pluck('ip_client');
    $totalRevenue = Order::sum('prix_produit'); // Montant total des produits commandés

    // Calculer les revenus de la dernière période (exemple : la semaine dernière)
    $lastWeekRevenue = Order::where('date_order', '>=', now()->subWeek())->sum('prix_produit');
    $lastWeekOrders = Order::where('date_order', '>=', now()->subWeek())->count();

    // Calculer les pourcentages de variation par rapport à la période précédente
    $revenuePercentage = $totalRevenue > 0 ? (($lastWeekRevenue - $totalRevenue) / $totalRevenue) * 100 : 0;
    $orderPercentage = $totalOrders > 0 ? (($lastWeekOrders - $totalOrders) / $totalOrders) * 100 : 0;

    // Récupérer les statistiques mensuelles
    $currentYear = now()->year;
    $monthlyTotalOrders = Order::selectRaw('COUNT(DISTINCT red_order) as total_orders, strftime("%m", created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyPendingOrders = Order::where('status', 'pending')
        ->selectRaw('COUNT(DISTINCT red_order) as pending_orders, strftime("%m", created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyDeliveredOrders = Order::where('status', 'delivered')
        ->selectRaw('COUNT(DISTINCT red_order) as delivered_orders, strftime("%m", created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyCanceledOrders = Order::where('status', 'canceled')
        ->selectRaw('COUNT(DISTINCT red_order) as canceled_orders, strftime("%m", created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // Fetch the sex distribution with counts (grouped by red_order)
    $sexDistribution = Order::selectRaw('sex, count(distinct red_order) as count')
        ->groupBy('sex')
        ->get();

    // Define age ranges and their labels
    $ageRanges = [
        '18-20' => [18, 20],
        '20-22' => [20, 22],
        '22-25' => [22, 25],
        '25-30' => [25, 30],
        '30-35' => [30, 35],
        '35-40' => [35, 40],
        '40-50' => [40, 50],
        '50+' => [50, 100],  // Consider all ages 50 and above as the last range
    ];

    // Initialize an array to store the age distribution counts
    $ageDistribution = [];

    // Loop through each age range and get the count of orders for that range
    foreach ($ageRanges as $label => [$minAge, $maxAge]) {
        $ageDistribution[$label] = Order::selectRaw('count(*) as count')
            ->whereRaw('FLOOR((julianday("now") - julianday(date_naissance)) / 365.25) BETWEEN ? AND ?', [$minAge, $maxAge])
            ->count();
    }

 // Calculer les produits populaires en fonction du total des quantités vendues
$topProducts = Order::select('id_produit', DB::raw('SUM(quantite_produit) as total_quantity_sold'))
->groupBy('id_produit') // Regrouper par produit
->orderByDesc('total_quantity_sold') // Trier par quantité totale vendue (du plus grand au plus petit)
->limit(5) // Limiter à 5 produits
->get();

// Récupérer les détails des produits populaires
$topProductsDetails = Product::whereIn('id', $topProducts->pluck('id_produit'))
->get();

// Récupérer les commandes récentes
$orders = Order::latest()->limit(5)->get();

$topSKU = DB::table('orders')
->join('products', 'orders.id_produit', '=', 'products.id')
->select(
    'products.SKU', 
    'products.name', 
    DB::raw('SUM(orders.quantite_produit) as total_quantity_sold'),
    DB::raw('SUM(orders.quantite_produit * orders.prix_produit) as total_revenue')
)
->groupBy('products.SKU', 'products.name')
->orderByDesc('total_revenue')
->limit(10)
->get();

$topOrders = Order::select(
    'red_order AS reference_commande',
    DB::raw('CONCAT(nom, " ", prenom) AS nom_client'),
    DB::raw('SUM(prix_produit * quantite_produit) AS chiffre_affaires')
)
->groupBy('red_order', 'nom', 'prenom')
->orderByDesc('chiffre_affaires')
->limit(10)
->get();
// Commandes pour cette semaine
$thisWeekOrders = Order::selectRaw('YEAR(date_order) as year, MONTH(date_order) as month, COUNT(*) as count')
->where('date_order', '>=', now()->startOfWeek())
->where('date_order', '<=', now()->endOfWeek())
->groupBy('year', 'month')
->orderBy('year')
->orderBy('month')
->get();

// Commandes pour la semaine dernière
$lastWeekOrders = Order::selectRaw('YEAR(date_order) as year, MONTH(date_order) as month, COUNT(*) as count')
->where('date_order', '>=', now()->subWeek()->startOfWeek())
->where('date_order', '<=', now()->subWeek()->endOfWeek())
->groupBy('year', 'month')
->orderBy('year')
->orderBy('month')
->get();

// Formater les données pour Google Charts
$thisWeekData = $thisWeekOrders->map(function ($order) {
return [\Carbon\Carbon::createFromDate($order->year, $order->month, 1)->format('M Y'), $order->count];
});

$lastWeekData = $lastWeekOrders->map(function ($order) {
return [\Carbon\Carbon::createFromDate($order->year, $order->month, 1)->format('M Y'), $order->count];
});
    // Passer les données à la vue
    return view('admin.dashboard', [
        'totalOrders' => $totalOrders,
        'totalAmount' => $totalAmount,
        'statusData' => $statusData,
        'paymentData' => $paymentData,
        'sourceData' => $sourceData,
        'ipData' => $ipData,
        'totalRevenue' => $totalRevenue,
        'lastWeekRevenue' => $lastWeekRevenue,
        'lastWeekOrders' => $lastWeekOrders,
        'revenuePercentage' => $revenuePercentage,
        'orderPercentage' => $orderPercentage,
        'monthlyTotalOrders' => $monthlyTotalOrders,
        'monthlyPendingOrders' => $monthlyPendingOrders,
        'monthlyDeliveredOrders' => $monthlyDeliveredOrders,
        'monthlyCanceledOrders' => $monthlyCanceledOrders,
        'sexDistribution' => $sexDistribution,
        'ageDistribution' => $ageDistribution,
        'topProducts' => $topProducts,
'orders' => $orders,
'topSKU'=>$topSKU,
'topOrders'=>$topOrders,
'thisWeekData'=>$thisWeekData,
'lastWeekData'=>$lastWeekData,

     ]);
}
   
   
   public function Traffic()
   {
         // Visiteurs d'aujourd'hui
         $todayVisitors = VisitorLog::whereDate('visit_time', now()->toDateString())->count();

         // Visiteurs d'hier
         $yesterdayVisitors = VisitorLog::whereDate('visit_time', now()->subDay()->toDateString())->count();
 
         // Pages les plus visitées (Top 10)
         $mostVisitedPages = VisitorLog::select('visited_page', \DB::raw('COUNT(*) as visits'))
             ->groupBy('visited_page')
             ->orderBy('visits', 'desc')
             ->limit(10)
             ->get();
 
         // Systèmes d'exploitation les plus utilisés
         $topOS = VisitorLog::select('os', \DB::raw('COUNT(*) as count'))
             ->groupBy('os')
             ->orderBy('count', 'desc')
             ->get();
 
         // Visiteurs en ligne (moins de 5 minutes)
         $onlineVisitors = VisitorLog::where('visit_time', '>=', now()->subMinutes(5))->count();
 
         // Retourner la vue avec les données collectées
         return view('admin.traffic', compact(
             'todayVisitors', 'yesterdayVisitors', 'mostVisitedPages', 'topOS', 'onlineVisitors'
         ));
     }
   
 
     public function createUser()
    {
        return view('admin.add-user');
    }

    /**
     * Ajouter un nouvel utilisateur.
     */
    public function registerUser(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'utype' => 'in:USR,ADM', // Assure que le rôle est soit 'USR' soit 'ADM'
        ]);

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'utype' => $request->utype ?? 'USR', // Défaut à 'USR'
        ]);

        // Redirection après succès
        return redirect()
            ->route('admin.add-user')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }


    public function indexUsers()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Passer les utilisateurs à la vue
        return view('admin.users', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'utype' => 'required|in:USR,ADM',
        ]);
    
        $user = User::findOrFail($id);
        $user->update($request->all());
    
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
     

    //Login 

    public function showLogin()
    {
        return view('admin.login'); // Assurez-vous que la vue se trouve dans resources/views/auth/login.blade.php
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return redirect()->route('admin.dashboard')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ])->withInput();
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Déconnecté avec succès.');
    }

    // Afficher le formulaire de réinitialisation de mot de passe
    public function showForgotPasswordForm()
    {
        return view('admin.login'); // Assurez-vous que cette vue existe
    }

    // Envoyer le lien de réinitialisation de mot de passe
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Lien de réinitialisation envoyé à votre adresse e-mail.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
    public function showProfile()
    {
        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            // Récupérer les informations de l'utilisateur connecté
            $user = Auth::user();  // Récupère l'utilisateur authentifié

            // Vous pouvez aussi ajouter d'autres informations comme le nombre de messages non lus, etc.
            $user->inbox_count = 27;  // Exemple : nombre de messages non lus (vous pouvez le calculer dynamiquement)

            // Retourner la vue avec les données de l'utilisateur
            return view('admin.dashboard', compact('user'));
        }

        // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
        return redirect()->route('login');
    }

    public function attribut_store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'values' => 'required|array', // Vérifier que 'values' est un tableau
            'values.*' => 'string|max:255', // Vérifier que chaque élément du tableau est une chaîne de caractères
        ]);
    
        // Récupérer les valeurs sous forme de tableau
        $values = $request->input('values'); 
    
        // Convertir en chaîne séparée par des virgules (si tu veux stocker une chaîne dans la base)
        $valuesString = implode(',', $values);
    
        // Créer un nouvel attribut dans la base de données
        Attribut::create([
            'nom' => $request->input('nom'),
            'value' => $valuesString, // Enregistrer les valeurs sous forme de chaîne séparée par des virgules
        ]);
    
        // Redirection avec un message de succès
        return redirect()->route('admin.add-attribut')->with('success', 'Attribut créé avec succès!');
    }
    
    public function listAttributs()
{
    // Récupérer tous les attributs depuis la base de données
    $attributs = Attribut::all();

    // Passer les attributs à la vue 'attributs'
    return view('admin.attributs', compact('attributs'));
}

    
public function updateAttributs(Request $request, $id)
{
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'value' => 'required|string|max:255',
    ]);

    // Trouver l'attribut par son ID
    $attribut = Attribut::findOrFail($id);

    // Mettre à jour les valeurs de l'attribut
    $attribut->nom = $validatedData['nom'];
    $attribut->value = $validatedData['value'];
    
    // Sauvegarder les modifications
    $attribut->save();

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'L\'attribut a été mis à jour avec succès.');
}

 
      



}
 

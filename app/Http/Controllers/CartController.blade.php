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



public function addToCart(Request $request)
{
    // Récupérer les informations du produit
    $product = Product::find($request->id);
    
    // Ajouter le produit au panier (session)
    $cart = session()->get('cart', []);
    
    if(isset($cart[$request->id])) {
        $cart[$request->id]['quantity']++;
    } else {
        $cart[$request->id] = [
            'name' => $product->name,
            'price' => $product->sale_price ?? $product->regular_price,
            'quantity' => 1
        ];
    }

    session()->put('cart', $cart);
    
    return response()->json($cart);
}
}
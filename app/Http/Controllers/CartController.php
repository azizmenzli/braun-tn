<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart', compact('products', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès');
    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Produit retiré du panier avec succès');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Panier mis à jour avec succès');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Panier vidé avec succès');
    }
} 
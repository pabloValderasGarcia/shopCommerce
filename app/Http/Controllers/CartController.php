<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function index() {
        $carts = Cart::where('idUser', Auth::id());
        if (count($carts->get()) > 0) {
            return view('cart.show', ['carts' => $carts->get()]);
        } else {
            return redirect('/')->withErrors(['message' => "You don't have any product in your cart..."]);
        }
    }
    
    public function addCart(Product $product, $qty) {
        if (Auth::check()) {
            $prod_check = Product::where('id', $product->id)->exists();
            if ($prod_check) {
                if (Cart::where('idProduct', $product->id)->where('idUser', Auth::id())->exists()) {
                    return back()->withErrors(['message' => 'Product already added to your cart...']);
                } else {
                    $cartItem = new Cart();
                    $cartItem->quantity = $qty;
                    $cartItem->idUser = Auth::id();
                    $cartItem->idProduct = $product->id;
                    try {
                        $cartItem->save();
                        return back()->with('message', 'Product added to your cart!');
                    } catch (\Exception $e) {
                        return back()->withErrors(['message', 'Could not add ' . $product->name . ' to cart']);
                    }
                }
            }
        } else {
            return back()->withErrors(['message' => 'Login to add products to your cart...']);
        }
    }
    
    public function update(Request $request, Cart $cart) {
        $data = $request->all();

        try {
            foreach ($data as $key => $value) {
                if(explode('_', $key)[0] == 'quantity') {
                    $cart = Cart::where('id', explode('_', $key)[1])->first();
                    $cart->quantity = $value;
                    $cart->save();
                }
            }
            return back()->with('message', 'Cart has been updated.');
        } catch (\Exception $e) {
            return back()->withErrors(['message', 'Could not update cart...']);
        }
    }
    
    public function show(Cart $carts) {
        return abort(404);
    }
    
    public function destroy(Cart $cart) {
        $name = $cart->product->name;
        $message = 'Product ' . $name . ' has not been removed.';

        if($cart->deleteCart()){
           $message = 'Product ' . $name . ' has been removed.';
           return back()->with('message', $message);
        }
    }
}

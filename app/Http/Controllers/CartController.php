<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('home.cart');
    }

    public function addToCart(Product $product)
    {
        $cart = Cart::instance('laralearn');

        if ($cart->has($product)) {
            if ($cart->count($product) < $product->inventory) {
                $cart->update($product, 1);
            }
        } else {
            $cart->put([
                'quantity' => 1,
            ], $product);
        }

        return redirect('/cart');
    }

    public function quantityChange(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required',
            'cart' => 'required'
        ]);

        $cart = Cart::instance($data['cart']);

        if ($cart->has($data['id'])) {

            $cart->update($data['id'], [
                'quantity' => $data['quantity']
            ]);

            return response(['status' => 'success']);
        }

        return response(['status' => 'error'], 404);
    }

    public function deleteFromCart($id)
    {
        $cart = Cart::instance('laralearn');

        $cart->delete($id);

        return back();
    }
}

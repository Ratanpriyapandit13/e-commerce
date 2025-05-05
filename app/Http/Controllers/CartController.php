<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function list()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = Cart_item::where('user_id', Auth::id())->with('product')->get();
        return view('cart-list', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            Cart_item::create([
                'product_id' => $product->id,
                'user_id' =>  Auth::id(),
                'quantity' => $request->input('quantity'),
                'price' => $product->price,
            ]);

            return redirect()->route('cart-list')->with('success', 'Product added to cart!');
        } else {
            session()->put('is_addCart_page', true);
            return redirect()->route('login');
        }
    }


    public function remove($id)
    {
        $cartItem = Cart_item::where('id', $id)
            ->where('user_id', Auth::id()) // Ensure it belongs to the logged-in user
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart-list')->with('success', 'Item removed from cart.');
        } else {
            return redirect()->route('cart-list')->with('error', 'Item not found or unauthorized.');
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = Cart_item::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
        ]);
    }
}

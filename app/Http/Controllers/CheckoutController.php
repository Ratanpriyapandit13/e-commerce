<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout($slug){
        $order = Order::where('user_id', Auth::id())
        ->with('items.product')
        ->latest()
        ->first();


        return view('checkout',compact('order'));
    }


    public function store(Request $request)
    {
        $cartItems = Cart_item::where('user_id', Auth::user()->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'totalPrice' => $total,
            'payment_method' => 'cod',
            'payment_status' => 'unpaid'
        ]);

        foreach ($cartItems as $item) {
            Order_item::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);


            $item->product->decrement('stock', $item->quantity);
        }

        // Cart_item::where('user_id', Auth::user()->id)->delete();

        return redirect()->route('checkout', $order->id)->with('success', 'Order placed successfully!');
        // return redirect()->route('home');
    }
}

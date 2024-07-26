<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\payment;
use App\Models\Order;
use App\Models\cart;
use Illuminate\Support\Facades\Auth;


class ordersController extends Controller
{
    public function placeOrder(Request $request){

        $cartItems=cart::where('user_id',Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            flash()->timeout(5000)->option('position', 'bottom-right')->error('your cart is empty');
            return redirect()->back();
        }
        $cart=[];
            foreach($cartItems as $item){

                $cart[$item->product_id] = [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'image'=>$item->product->image,
                    'quantity' => $item->quantity,
                ];
            }
            $order = new order();
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->customer_id = Auth::user()->id;
            $order->order_items = json_encode($cart);
            $order->sub_total = $this->calculateSubTotal($cart);
            $order->save();

        $cart_remove=cart::where('user_id',Auth::id())->get();
        foreach($cart_remove as $remove) {
            $data=cart::find($remove->id);
            $data->delete();
        }
        sweetalert()->success('Your order has been placed');
        return redirect()->back();
    }
    private function calculateSubTotal($cart){
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\payment;
use App\Models\Order;
use App\Models\cart;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;


class ordersController extends Controller
{
    public $cartjson;
    public function __construct(){
       $cartItems=cart::where('user_id',Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return $this->cartjson=null;
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
        $cart_remove=cart::where('user_id',Auth::id())->get();
        foreach($cart_remove as $remove) {
            $data = cart::find($remove->id);
            $data->delete();
        }
        return $this->cartjson=$cart;
    }

    private function calculateSubTotal($cart){
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    public function placeOrder(Request $request){
        if($this->cartjson==null)
        {
            flash()->timeout(5000)->option('position', 'bottom-right')->error('your cart is empty');
            return redirect()->back();
        }
        else {
            $order = new order();
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->customer_id = Auth::user()->id;
            $order->order_items = json_encode($this->cartJson);
            $order->sub_total = $this->calculateSubTotal($this->cartJson);
            $order->save();
            sweetalert()->success('Your order has been placed');
            return redirect()->back();
        }
    }
    public function payWithPaypal()
    {
        payment::create([
            'payment_id'=>"#".random_int(1,10000),
            'payer_name'=>request()->name,
            'payer_id'=>"#".auth::id(),
            'amount'=>$this->calculateSubTotal($this->cartJson())
        ]);
        order::create([
           'payment_status'=>'Paypal',
        ]);

    }

}

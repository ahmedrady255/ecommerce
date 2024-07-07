<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\support\Facades\auth;
use App\Models\cart;
use App\Models\Order;

class CartController extends Controller
{
    public function index(){
        if(auth::user()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = cart::where('user_id', $user_id)->count();
            $cart = cart::where('user_id', $user_id)->get();
            $total = 0;

            foreach($cart as $item){
                $total += $item->product->price;
            }
        }

        return view('cart.index',compact('count','cart','total'));
    }
    public function delete($id){
        $item=cart::find($id);
        $item->delete();
        return redirect()->back();
    }
    public function placeOrder(Request $request){

        $cart=cart::where('user_id',Auth::id())->get();


        foreach($cart as $cart) {

            $order = new order();
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->customer_id = auth::user()->id;
            $order->product_id = $cart->product_id;
            $order->save();
        }
        $cart_remove=cart::where('user_id',Auth::id())->get();
        foreach($cart_remove as $remove) {
            $data=cart::find($remove->id);
            $data->delete();
        }
        return redirect()->back();
    }
    public function payWithPaypal(request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $count = cart::where('user_id', $user_id)->count();
        $cart=cart::where('user_id',Auth::id())->get();
        $total=0;

        foreach($cart as $cart) {

            $order = new order();
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->customer_id = auth::user()->id;
            $order->payment_status='Paypal';
            $order->product_id = $cart->product_id;
            $total+=$cart->product->price;
            $order->save();
        }
        $payment=new payment();
        $payment->payer_name= $request->name;
        $payment->payer_id= auth::user()->id;
        $payment->amount= $total;
        $payment->save();
        $paymentID=payment::where('payer_id',auth::user()->id)->where('amount',$total)->where('created_at',now())->value('id');

        $cart_remove=cart::where('user_id',Auth::id())->get();
        foreach($cart_remove as $remove) {
            $data=cart::find($remove->id);
            $data->delete();
        }
        return to_route('payment',$paymentID);
    }
}

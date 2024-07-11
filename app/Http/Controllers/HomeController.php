<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\product;
use App\Models\cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\support\Facades\auth;




class HomeController extends Controller
{

    public function index(){
        $products = Product::all();
        if(Auth::id()){
            $user=Auth::user();
            $user_id=$user->id;
            $count=cart::where('user_id',$user_id)->count();
        }
        else
            $count='';
        return view('home.index',compact('products','count'));
    }
    public function home_login()
    {
        $products = Product::all();
        $user=Auth::user();
        $user_id=$user->id;
        $count=cart::where('user_id',$user_id)->count();

        return view('home.index',compact('products','count'));
    }

public function product_details($id)
{
    $product=product::with('images')->find($id);

    $products = Product::all();
    $user=Auth::user();
    $user_id=$user->id;
    $count=cart::where('user_id',$user_id)->count();
    return view('home.product_details',compact('product','count'));

}

    public function contactUS(){
        return view('home.contact-us');
    }
    public function add_cart($id){
        $product_id=$id;
        $user=Auth::user();
        $user_id=$user->id;
        $cart=cart::create([
            'user_id'=>$user_id,
            'product_id'=>$product_id,
        ]);
        $product=product::where('id',$product_id)->first();
        $quantity=$product->quantity-1;
        $product->update(['quantity'=>$quantity]);

        flash()->timeout(3000)->success('product added successfully');
        return redirect()->back();

    }
    public function myOrders(){
        if(Auth::id()){
            $user=Auth::user();
            $order=Order::where('customer_id',$user->id)->get();
            $count=cart::where('user_id',$user->id)->count();
        }
        else
            $count='';

        return view('home.myOrders',compact('order','count'));
    }
}

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
    $product = Product::with('images')->findOrFail($id);
    if(Auth::id()){
        $user=Auth::user();
        $user_id=$user->id;
        $count=cart::where('user_id',$user_id)->count();
    }
    else{
        $count=0;
    }

    return view('home.product_details',compact('product','count'));

}


    public function contactUS(){
        return view('home.contact-us');
    }

    public function myOrders(){
        if(Auth::id()){
            $user=Auth::user();
            $order=Order::where('customer_id',$user->id)->get();
            $count=cart::where('user_id',$user->id)->count();

        }
        else
            $count='';

        return view('home.myOrders',['orders'=>$order,'count'=>$count] );
    }
}

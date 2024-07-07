<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\support\Facades\auth;

class ShopController extends Controller
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
        $products = Product::all();

        return view('shop.index',['products'=>$products, 'count'=>$count]);
    }
}

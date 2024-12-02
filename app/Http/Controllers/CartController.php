<?php

namespace App\Http\Controllers;


use App\Models\product;
use GuzzleHttp\Psr7\Request;
use Illuminate\support\Facades\auth;
use App\Models\cart;
use Illuminate\Support\Facades\DB;


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
                $total += $item->product->price*$item->quantity;
            }
        }

        return view('cart.index',compact('count','cart','total'));
    }
    public function add_cart($id){

        $product_id=$id;

        $product=product::where('id',$product_id)->first();

        $cartQuantity=request()->quantity;

        if($product->quantity>=1) {

            $quantity = $product->quantity - $cartQuantity;

            $product->update(['quantity' => $quantity]);

            $user = Auth::user();

            $user_id = $user->id;
            $cartItem = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
            if ($cartItem) {
                $cartItem->update([
                    'quantity' => \DB::raw('quantity+' . $cartQuantity)
                ]);
                flash()->timeout(3000)->option('position', 'bottom-right')->success('product added successfully');

                return redirect()->back();
            }
         else {
             if($cartQuantity){
             cart::create([
                 'user_id' => $user_id,
                 'product_id' => $product_id,
                 'quantity' => $cartQuantity
             ]);}
             else{
                 cart::create([
                     'user_id' => $user_id,
                     'product_id' => $product_id]);
             }

             flash()->timeout(3000)->option('position', 'bottom-right')->success('product added successfully');

             return redirect()->back();
         }

        }

        else
        {

            flash()->timeout(3000)->option('position','bottom-right')->error('Out of stock');

            return redirect()->back();
        }
    }
    public function delete($id){

        $item=cart::find($id);
//        $product=Product::find($item->product_id);
//
////        $productQuantity=$product->quantity+$item->quantity;
//
//       $product->update([
//            'quantity'=> \DB::raw('quantity+'.$item->quantity)
//        ]);
//
        $item->delete();

        return redirect()->back();
    }


}

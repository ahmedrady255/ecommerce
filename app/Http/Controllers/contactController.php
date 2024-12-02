<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\messages;
use Illuminate\Http\Request;

class contactController extends Controller
{

    public function index(){
      $count=Cart::all()->count();
        return view('contact-us.index',compact('count'));
    }
    public function storeMsg(){
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);
        messages::create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'message' => request('message'),

        ]);
        flash()->timeout(3000)->option('position', 'bottom-right')->success('your message has been sent successfully, we will get back to you soon');
        return redirect()->back();

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;

class whyController extends Controller
{
    public function index(){
        $count=Cart::count();
        return view('why.index' ,compact('count'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        $count=cart::count();
        return view('testimonial.index',compact('count'));
    }
}

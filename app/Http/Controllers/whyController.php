<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class whyController extends Controller
{
    public function index(){
        return view('why.index');
    }
}

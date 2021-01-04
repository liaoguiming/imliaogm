<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //
    public function index()
    {
        $flag = "cart";
        return view('home.business.cart', compact('flag'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class productuser extends Controller
{
     public function index() : View {
        // get data from model
        $productsuser = Product::all();
        // render view
        return view('User.Product.view', compact('productsuser'));
    }
}

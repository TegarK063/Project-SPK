<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index() : View {
        // get data from model
        $products = Product::all();
        // render view
        return view('Admin.Product.view', compact('products'));
    }
}
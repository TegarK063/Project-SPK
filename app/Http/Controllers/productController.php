<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index() : View {
        // get data from model
        $products = Product::all();
        // render view
        return view('Admin.Product.view', compact('products'));
    }

    public function create() : View {
        return view('Admin.Product.create');
    }

    public function store(Request $request) : RedirectResponse
    {
        // Validasi data
        $request->validate
        ([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'series' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('/products', $image->hashName());

        // create data
        Product::create([
            'image' => $image->hashName(),
            'series' => $request->series,
            'storage' => $request->storage,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        // redirect to index
        return redirect()->route('Products.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }
    public function show($id) : View
    {
        // get  data by id
        $product = Product::findOrFail($id);
        // render view
        return view('Admin.Product.show', compact('product'));
    }
}

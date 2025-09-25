<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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

    public function edit($id) : View
    {
        // get  data by id
        $product = Product::findOrFail($id);
        // render view
        return view('Admin.Product.edit', compact('product'));
    }

    public function update(Request $request, $id) : RedirectResponse
    {
        // Validasi data
        $request->validate
        ([
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'series' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        // get data by id
        $product = Product::findOrFail($id);

        // check if image is uploaded
        if ($request->hasFile('image')) {
            // upload new image
            $image = $request->file('image');
            $image->storeAs('/products', $image->hashName());

            // delete old image
            Storage::delete('/products/' . $product->image);

            // update data with new image
            $product->update([
                'image' => $image->hashName(),
                'series' => $request->series,
                'storage' => $request->storage,
                'description' => $request->description,
                'price' => $request->price,
            ]);
        } else {
            // update data without new image
            $product->update([
                'series' => $request->series,
                'storage' => $request->storage,
                'description' => $request->description,
                'price' => $request->price,
            ]);
        }

        // redirect to index
        return redirect()->route('Products.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id) : RedirectResponse
    {
        // get data by id
        $product = Product::findOrFail($id);

        // delete image
        Storage::delete('/products/' . $product->image);

        // delete data
        $product->delete();

        // redirect to index
        return redirect()->route('Products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}

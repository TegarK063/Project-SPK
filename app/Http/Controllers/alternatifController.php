<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class alternatifController extends Controller
{
    public function index() : View
    {
        // get data from model
        $alternatifs = alternatif::with('product')->get();
        // render view
        return view('User.Alternatif.view', compact('alternatifs'));
    }

    public function create() : View
    {
        // get data from model product
        $products = Product::all();
        // Generate kode_alternatif otomatis
        $last = alternatif::orderBy('id', 'desc')->first();
        $newNumber = $last ? (int) substr($last->kode_alternatif, 1) + 1 : 1;
        $kode_alternatif = 'A' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        return view('User.Alternatif.create', compact('kode_alternatif', 'products'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif',
            'product_id' => 'required|exists:products,id',
            'performance' => 'required|integer|min:1|max:100',
            'camera' => 'required|integer|min:1|max:100',
            'battery' => 'required|integer|min:1',
            'aftersales' => 'required|integer|min:1|max:10',
        ]);
        // simpan data
        alternatif::create($request->all());
        // redirect to index
        return redirect()->route('Alternatif.index')->with('success', 'Data Berhasil Disimpan!');
    }

    public function edit($id) : View
    {
        $alt = alternatif::findOrFail($id);
        $products = Product::all();
        return view('User.Alternatif.edit', compact('alt', 'products'));
    }

    public function update(Request $request, $id) : RedirectResponse
    {
        $alt = alternatif::findOrFail($id);
        $request->validate([
            'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif,' . $alt->id,
            'product_id' => 'required|exists:products,id',
            'performance' => 'required|integer|min:1|max:100',
            'camera' => 'required|integer|min:1|max:100',
            'battery' => 'required|integer|min:1',
            'aftersales' => 'required|integer|min:1|max:10',
        ]);
        $alt->update($request->all());
        return redirect()->route('Alternatif.index')->with('success', 'Data Berhasil Diupdate!');
    }
}
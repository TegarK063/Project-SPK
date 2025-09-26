<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class kriteriaController extends Controller
{
    public function index() : View
    {
        // get data from model kriteria
        $kriterias = kriteria::all();
        // render view
        return view('Admin.Kriteria.view', compact('kriterias'));
    }

    public function create(): View
    {
        $last = kriteria::orderBy('id', 'desc')->first();
        $newNumber = $last ? (int) substr($last->kode_kriteria, 1) + 1 : 1;
        $kode_kriteria = 'C' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        return view('Admin.Kriteria.create', compact('kode_kriteria'));
    }


    public function store(Request $request) : RedirectResponse
    {
        // validasi data (tanpa kode_kriteria karena akan otomatis)
        $request->validate([
            'nama_kriteria' => 'required',
            'type' => 'required|in:Cost,Benefit',
            'bobot' => 'required|numeric|min:0',
        ]);

        // Generate kode_kriteria otomatis
        $last = kriteria::orderBy('id', 'desc')->first();
        if($last) {
            // ambil nomor terakhir dari kode terakhir, misal K05 => 5
            $lastNumber = (int) substr($last->kode_kriteria, 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $kode_kriteria = 'C' . str_pad($newNumber, 2, '0', STR_PAD_LEFT); // K01, K02, dll

        // simpan data
        kriteria::create([
            'kode_kriteria' => $kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'type' => $request->type,
            'bobot' => $request->bobot,
        ]);
        // redirect to index
        return redirect()->route('Kriteria.index')->with('success', 'Data Berhasil Disimpan!');
    }

}

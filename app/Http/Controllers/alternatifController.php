<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use Illuminate\Contracts\View\View;
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
}

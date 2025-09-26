<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class kriteriaController extends Controller
{
    public function index() : View
    {
        // get data from model kriteria
        $kriterias = kriteria::all();
        // render view
        return view('Admin.Kriteria.view', compact('kriterias'));
    }
}
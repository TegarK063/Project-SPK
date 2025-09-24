<?php

use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});

Route::resource('/Products', productController::class);
Route::view('/form', 'form');
Route::view('/Productadd', 'Admin.Product.add');
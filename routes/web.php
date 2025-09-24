<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});
Route::view('/form', 'form');
Route::view('/ProductView', 'Admin.Product.view');
Route::view('/Productadd', 'Admin.Product.add');
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});
Route::view('/modal', 'modal');
Route::view('/form', 'form');
Route::view('/ProductView', 'Admin.Product.view');
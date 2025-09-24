<?php

use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingPage');
});

Route::resource('/Products', productController::class);
Route::view('/form', 'Admin.Product.show')->name('form');
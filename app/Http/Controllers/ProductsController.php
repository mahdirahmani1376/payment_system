<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Storage\Contracts\SessionStorage;

class ProductsController extends Controller
{
    public function index(SessionStorage $sessionStorage)
    {
        $sessionStorage->set('product',5);

        $products = Product::all();

        return view('products',compact($products));
    }
}

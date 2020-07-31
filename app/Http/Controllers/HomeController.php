<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->limit(6)->orderBy('id', 'desc')->get();
        $stores = \App\Models\Store::limit(3)->orderBy('id', 'desc')->get(['name', 'logo', 'slug']);
        return view('welcome', compact(['products', 'stores']));
    }

    public function single($slug)
    {
        $product = $this->product->whereSlug($slug)->firstOrFail();
        return view('single', compact('product'));
    }
}

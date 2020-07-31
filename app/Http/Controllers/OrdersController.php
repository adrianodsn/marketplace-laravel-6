<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(15);
        return view('orders', compact('orders'));
    }
}

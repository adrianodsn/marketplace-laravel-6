<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $user = auth()->user();

        if (!$user->store()->exists()) {
            flash('É necessário criar uma loja para receber pedidos.')->warning();
            return redirect()->route('admin.stores.index');
        }

        $orders = $user->store->orders()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];

        if (!$cart) {
            session()->forget('cart');
        }

        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $productData = $request->get('product');

        if ($productData['amount'] <= 0) {
            return redirect()->route('home');
        }

        $product = \App\Models\Product::whereSlug($productData['slug'])->firstOrFail(['name', 'price', 'store_id'])->toArray();

        $product = array_merge($productData, $product);

        if (session()->has('cart')) {
            $cart = session()->get('cart');
            $productsSlugs = array_column($cart, 'slug');

            if (in_array($product['slug'], $productsSlugs)) {
                $cart = $this->productIncrement($product['slug'], $cart, $product['amount']);
                session()->put('cart', $cart);
            } else {
                session()->push('cart', $product);
            }
        } else {
            $cart[] = $product;
            session()->put('cart', $cart);
        }

        flash('Produto adicionado ao carrinho.')->success();
        return redirect()->route('product.single', ['slug' => $product['slug']]);
    }

    public function remove(Request $request)
    {
        $data = $request->all(['slug', 'name']);
        $name = $data['name'];
        $slug = $data['slug'];

        if (session()->has('cart')) {

            $cart = session()->get('cart');

            $cart = array_filter($cart, function ($line) use ($slug) {
                return $line['slug'] != $slug;
            });

            flash("Produto \"$name\" removido do carrinho.")->success();
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function cancel()
    {
        session()->forget('cart');
        flash("Pedido cancelado.")->success();
        return redirect()->route('cart.index');
    }

    private function productIncrement($slug, $cart, $amount)
    {
        $cart = array_map(function ($line) use ($slug, $amount) {

            if ($slug == $line['slug']) {
                $line['amount'] += $amount;
            }

            return $line;
        }, $cart);

        return $cart;
    }
}

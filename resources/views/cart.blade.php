@extends('layouts.front')

@section('content')
    @if ($cart)
        <h2 class="mb-5">Carrinho</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $c)
                    @php
                    $subtotal = $c['price']*$c['amount'];
                    $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $c['name'] }}</td>
                        <td>R$ {{ number_format($c['price'], 2, ',', '.') }}</td>
                        <td>{{ $c['amount'] }}</td>
                        <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                        <td class="text-right">
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input name="name" type="hidden" value="{{ $c['name'] }}">
                                <input name="slug" type="hidden" value="{{ $c['slug'] }}">
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><b>Total:</b></td>
                    <td colspan="2"><b>R$ {{ number_format($total, 2, ',', '.') }}</b></td>
                </tr>
            <tbody>
        </table>

        <div class="text-center">
            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg float-md-right">
                Confirmar pedido
            </a>
            <form action="{{ route('cart.cancel') }}" method="POST" class="float-md-left">
                @csrf
                @method('DELETE')
                <button class="btn btn-link btn-sm" type="submit">Cancelar compra</button>
            </form>
        </div>

    @else
        <div class="jumbotron">
            <h2>Carrinho vazio</h2>
            <p>Navege pela nossa loja e adicione os produtos ao carrinho.</p>
        </div>
    @endif
@endsection

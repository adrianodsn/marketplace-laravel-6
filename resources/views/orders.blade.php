@extends('layouts.front')

@section('content')

    <h3 class="mb-5">Meus pedidos</h3>

    @if ($orders->count())

        <div class="accordion mb-5" id="accordionExample">
            @foreach ($orders as $key => $order)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                Pedido #{{ $order->reference }}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $key }}" class="collapse @if ($key == 0) show @endif" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <ul>
                                    @foreach (unserialize($order->items) as $item)
                                        <li>
                                            <div><b>{{ $item['amount'] }} {{ $item['name'] }}</b></div>
                                            R$ {{ number_format($item['price'], 2, ',', '.') }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $orders->links() }}

        @endif
    @endsection

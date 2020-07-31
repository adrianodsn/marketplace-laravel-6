@extends('layouts.front')

@section('content')

<div class="jumbotron">
    <h2>Obrigado por sua compra!</h2>
    <p>Seu pedido {{request()->get('orderReference')}} foi processado.</p>
</div>

@endsection
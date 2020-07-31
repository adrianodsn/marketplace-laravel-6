@extends('layouts.front')

@section('pageTitle', 'Home | ')

@section('content')
    <div class="row">
        @foreach ($products as $key => $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if ($product->photos->count())                    
                    <img src="{{asset('storage/'.$product->thumb)}}" alt="{{$product->name}}" class="card-img-top">
                @else
                    <img src="{{asset('assets/img/no-photo.jpg')}}" alt="{{$product->name}}" class="card-img-top">
                @endif
                <div class="card-body">
                    <h2 class="card-title">
                        {{$product->name}}
                    </h2>
                    <p class="card-text">
                        {{$product->description}}
                    </p>
                    <h4>
                        R$ {{number_format($product->price, 2, ',', '.')}}
                    </h4>
                    <div>
                        <a href="{{route('product.single',['slug'=>$product->slug])}}" class="btn btn-success">Ver produto</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        @foreach ($stores as $store)
        <div class="col-md-4">
            @if ($store->logo)
                <img alt="{{$store->name}}" class="img-fluid mb-3" src="{{asset('storage/'.$store->logo)}}">
            @else
                <img alt="{{$store->name}}" class="img-fluid mb-3" src="https://via.placeholder.com/500X200.png?text={{$store->name}}">
            @endif
            <h3>{{$store->name}}</h3>
            <p>{{$store->description}}</p>
            <a href="{{route('store.single', ['slug'=>$store->slug])}}" class="btn btn-success btn-sm">Ver loja</a>
        </div>
        @endforeach
    </div>
@endsection
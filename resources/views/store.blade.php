@extends('layouts.front')

@section('content')

    <div class="row">
        <div class="col-md-3">
            @if ($store->logo)
                <img alt="{{$store->name}}" class="img-fluid" src="{{asset('storage/'.$store->logo)}}">
            @else
                <img alt="{{$store->name}}" class="img-fluid mb-3" src="https://via.placeholder.com/500X200.png?text={{$store->name}}">
            @endif
        </div>
        <div class="col-md-9">
            <h1>{{$store->name}}</h1>
            <p>{{$store->description}}</p>
            <p>{{$store->phone}} | {{$store->mobile_phone}}</p>
        </div>
    </div>

    <hr>

    @if ($store->products)
        <div class="row">
            @foreach ($store->products as $key => $product)        
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if ($product->photos->count())                    
                            <img src="{{asset('storage/'.$product->photos->first()->image)}}" alt="{{$product->name}}" class="card-img-top">
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
    @else
        <div class="alert alert-warning">
            Nenhum produto encontrado para a loja "{{$store->name}}".
        </div>    
    @endif

@endsection
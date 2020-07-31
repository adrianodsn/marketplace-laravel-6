@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @if ($product->photos->count())
                <img src="{{asset('storage/'.$product->photos->first()->image)}}" alt="{{$product->name}}" class="img-fluid mb-4">
                @if ($product->photos->count()>1)
                <div class="row">
                    @foreach ($product->photos as $photo)
                        <div class="col-4">
                            <img src="{{asset('storage/'.$photo->image)}}" alt="{{$product->name}}" class="img-fluid">
                        </div>
                    @endforeach
                </div>                    
                @endif
            @else
                <img src="{{asset('assets/img/no-photo.jpg')}}" alt="{{$product->name}}" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{$product->name}}</h1>
            <p>{{$product->description}}</p>
            <h3 class="text-success">R$ {{number_format($product->price, 2, ',', '.')}}</h3>
            <div class="small mb-3">Vendido por {{$product->store->name}}</div>
            <hr>
            <form action="{{route('cart.add')}}" method="POST">
                @csrf
                <input type="hidden" name="product[slug]" value="{{$product->slug}}">
                <div class="form-group">
                    <label for="amount">Quantidade</label>
                    <input class="form-control form-control-lg col-md-3" id="amount" min="1" name="product[amount]" type="number" value="1">
                </div>
                <button class="btn btn-success btn-lg col-md-3" type="submit">Comprar</button>
            </form>
        </div>
    </div>
    <hr>
    <div>{{$product->body}}</h1>
@endsection
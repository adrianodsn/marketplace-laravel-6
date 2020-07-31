@extends('layouts.front')

@section('content')

    <h1 class="mb-5">{{ $category->name }}</h1>

    @if ($category->products)
        <div class="row">
            @foreach ($category->products as $key => $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if ($product->photos->count())
                            <img src="{{ asset('storage/' . $product->photos->first()->image) }}" alt="{{ $product->name }}"
                                class="card-img-top">
                        @else
                            <img src="{{ asset('assets/img/no-photo.jpg') }}" alt="{{ $product->name }}" class="card-img-top">
            @endif
            <div class="card-body">
                <h2 class="card-title">
                    {{ $product->name }}
                </h2>
                <p class="card-text">
                    {{ $product->description }}
                </p>
                <h4>
                    R$ {{ number_format($product->price, 2, ',', '.') }}
                </h4>
                <div>
                    <a href="{{ route('product.single', ['slug' => $product->slug]) }}" class="btn btn-success">Ver produto</a>
                </div>
            </div>
            </div>
            </div>
        @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Nenhum produto encontrado para a categoria "{{ $category->name }}".
        </div>
    @endif

@endsection

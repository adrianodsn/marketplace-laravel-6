@extends('layouts.app')

@section('content')

<h3 class="mb-5">Produtos</h3>

<a class="btn btn-success mb-3" href="{{route('admin.products.create')}}">Adicionar</a>

@if ($products->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Produto</th>
            <th>Preço</th>
            <th>Categorias</th>
            <th>Imagens</th>
            <th>Loja</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>R$ {{number_format($product->price, 2, ',', '.')}}</td>
            <td>{{$product->categories->count()}}</td>
            <td>{{$product->photos->count()}}</td>
            <td>{{$product->store->name}}</td>
            <td class="text-right">
                <form action="{{route('admin.products.destroy', ['product'=>$product->id])}}" method="POST">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.products.edit', ['product'=>$product->id])}}">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmar exclusão?');">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{$products->links()}}
@endif
@endsection
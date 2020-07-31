@extends('layouts.app')

@section('content')

<h3 class="mb-5">Lojas</h3>

@if (!$store)
    <a class="btn btn-success mb-3" href="{{route('admin.stores.create')}}">Adicionar</a>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Loja</th>
            <th>Slug</th>
            <th>Usuário</th>
            <th>Produtos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$store->id}}</td>
            <td>{{$store->name}}</td>
            <td>{{$store->slug}}</td>
            <td>{{$store->user->name}}</td>
            <td>{{$store->products->count()}}</td>
            <td class="text-right">
                <form action="{{route('admin.stores.destroy', ['store'=>$store->id])}}" method="POST">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.stores.edit', ['store'=>$store->id])}}">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmar exclusão?');">Excluir</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
@endif

@endsection
@extends('layouts.app')

@section('content')

<h3 class="mb-5">Categorias</h3>

<a class="btn btn-success mb-3" href="{{route('admin.categories.create')}}">Adicionar</a>

@if ($categoriesAdmin->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Categorias</th>
            <th>Slug</th>
            <th>Produtos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categoriesAdmin as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->slug}}</td>
            <td>{{$category->products->count()}}</td>
            <td class="text-right">
                <form action="{{route('admin.categories.destroy', ['category'=>$category->id])}}" method="POST">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.categories.edit', ['category'=>$category->id])}}">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmar exclusão?');">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{$categoriesAdmin->links()}}

@endif    
@endsection
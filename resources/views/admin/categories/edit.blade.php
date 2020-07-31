@extends('layouts.app')

@section('content')

<h3 class="mb-5">Editar categoria</h3>

<form action="{{route('admin.categories.update', ['category'=>$category->id])}}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name">Categoria</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" maxlength="60" required value="{{old('name', $category->name)}}">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" maxlength="250" class="form-control" value="{{old('description', $category->description)}}">
    </div>

    <div>
        <button type="submit" class="btn btn-success btn-lg">Editar</button>
        <button class="btn btn-light btn-lg" onclick="history.back(); return false;">Cancelar</button>
    </div>
</form>
    
@endsection
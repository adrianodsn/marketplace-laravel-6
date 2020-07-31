@extends('layouts.app')

@section('content')

<h3 class="mb-5">Criar produto</h3>

<form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="form-group">
        <label for="name">Nome do produto</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" maxlength="60" required value="{{old('name')}}">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" maxlength="250" required class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
        @error('description')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="body">Conteúdo</label>
        <textarea name="body" id="body" required class="form-control @error('body') is-invalid @enderror" rows="10">{{old('body')}}</textarea>
        @error('body')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="price">Preço</label>
        <input type="text" name="price" id="price" required class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}">
        @error('price')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="categories">Categorias</label>
        <select type="text" name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" required multiple>
            @foreach ($categories as $category)
            <option value="{{$category->id}}"
                @if (in_array($category->id, old('categories', [])))
                selected @endif
                >{{$category->name}}</option>                
            @endforeach
        </select>
        @error('categories')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="photos">Fotos do produto</label>
        <input type="file" name="photos[]" id="photos" class="form-control-file @error('photos.*') is-invalid @enderror" multiple>
        @error('photos.*')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>
  
    <div>
        <button type="submit" class="btn btn-success btn-lg">Criar</button>
        <button class="btn btn-light btn-lg" onclick="history.back(); return false;">Cancelar</button>
    </div>
</form>
    
@endsection
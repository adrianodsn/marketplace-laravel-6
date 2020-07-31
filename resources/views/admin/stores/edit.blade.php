@extends('layouts.app')

@section('content')

<h3 class="mb-5">Editar loja</h3>

<form action="{{route('admin.stores.update', ['store'=>$store->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name">Nome da loja</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" maxlength="60" required value="{{old('name', $store->name)}}">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" maxlength="250" required class="form-control @error('description') is-invalid @enderror" value="{{old('description', $store->description)}}">
        @error('description')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Telefone</label>
        <input type="text" name="phone" id="phone" required class="form-control @error('phone') is-invalid @enderror"  value="{{old('phone', $store->phone)}}">
        @error('phone')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="mobile_phone">Celular</label>
        <input type="text" name="mobile_phone" id="mobile_phone" required class="form-control @error('mobile_phone') is-invalid @enderror" value="{{old('mobile_phone', $store->mobile_phone)}}">
        @error('mobile_phone')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        @if (!is_null($store->logo))
            <p>
                <img src="{{asset('storage/'.$store->logo)}}" alt="" class="img-fluid">
            </p>            
        @endif        
        <label for="logo">Logo</label>
        <input type="file" name="logo" id="logo" class="form-control-file @error('logo') is-invalid @enderror">
        @error('logo')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-success btn-lg">Editar</button>
        <button class="btn btn-light btn-lg" onclick="history.back(); return false;">Cancelar</button>
    </div>
</form>
    
@endsection
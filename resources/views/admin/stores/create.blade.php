@extends('layouts.app')

@section('content')

<h3 class="mb-5">Criar loja</h3>

<form action="{{route('admin.stores.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="form-group">
        <label for="name">Nome da loja</label>
        <input type="text" name="name" id="name" maxlength="60" required class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
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
        <label for="phone">Telefone</label>
        <input type="text" name="phone" id="phone" required class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}">
        @error('phone')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="mobile_phone">Celular</label>
        <input type="text" name="mobile_phone" id="mobile_phone" required class="form-control @error('mobile_phone') is-invalid @enderror" value="{{old('mobile_phone')}}">
        @error('mobile_phone')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="file" name="logo" id="logo" class="form-control-file @error('logo') is-invalid @enderror">
        @error('logo')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-success btn-lg">Criar</button>
        <button class="btn btn-light btn-lg" onclick="history.back(); return false;">Cancelar</button>
    </div>
</form>
    
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js"></script>
    <script>
         $('#phone').inputmask("(99) 9999-9999");
         $('#mobile_phone').inputmask("(99) 99999-9999");
    </script>
@endsection
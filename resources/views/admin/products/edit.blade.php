@extends('layouts.app')

@section('content')

    <h3 class="mb-5">Editar produto</h3>

    <form action="{{route('admin.products.update', ['product'=>$product->id])}}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div>
            {{$product->slug}}
        </div>
        
        <div class="form-group">
            <label for="name">Nome do produto</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" maxlength="60" required value="{{old('name', $product->name)}}">
            @error('name')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" maxlength="250" required class="form-control @error('description') is-invalid @enderror" value="{{old('description', $product->description)}}">
            @error('description')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Conteúdo</label>
            <textarea name="body" id="body" required class="form-control @error('body') is-invalid @enderror" rows="10">{{old('body', $product->body)}}</textarea>
            @error('body')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Preço</label>
            <input type="text" name="price" id="price" required class="form-control @error('price') is-invalid @enderror" value="{{number_format(old('price', $product->price), 2, ',', '.')}}">
            @error('price')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="categories">Categorias</label>
            <select type="text" name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" required multiple>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}"
                        @if (old('categories'))
                            @if (in_array($category->id, old('categories', []))) selected @endif
                        @else
                            @if ($product->categories->contains($category)) selected @endif
                        @endif
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
            <button type="submit" class="btn btn-success btn-lg">Editar</button>
            <button class="btn btn-light btn-lg" onclick="history.back(); return false;">Cancelar</button>
        </div>

    </form>

    <div class="row">
        @foreach ($product->photos as $photo)
            <div class="col-4">
                <img src="{{asset('storage/'.$photo->image)}}" alt="" class="img-fluid">
                <form action="{{route('admin.photo.remove')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <input type="hidden" name="image" value="{{$photo->image}}">
                    <button type="submit" class="btn btn-danger btn-lg">Excluir</button>
                </form>
            </div>
        @endforeach
    </div>
    
@endsection

@section('scripts')
    
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
    
    <script>
        $('#price').maskMoney({prefix: '', allowNegative: false, thousands: '.', decimal: ','});
    </script>

@endsection
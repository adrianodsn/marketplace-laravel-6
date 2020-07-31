<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle')Admin | Marketplace L6</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
    <a class="navbar-brand" href="{{route('admin.dashboard')}}">Marketplace L6</a>
    @auth
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(request()->is('admin/stores*')) active @endif">
              <a class="nav-link" href="{{route('admin.stores.index')}}">Loja</a>
            </li>
            <li class="nav-item @if(request()->is('admin/categories*')) active @endif">
                <a class="nav-link" href="{{route('admin.categories.index')}}">Categorias</a>
            </li>
            @if (auth()->user()->store()->exists())
              <li class="nav-item @if(request()->is('admin/orders*')) active @endif">
                <a class="nav-link" href="{{route('admin.orders')}}">Pedidos</a>
              </li>
              <li class="nav-item @if(request()->is('admin/products*')) active @endif">
                <a class="nav-link" href="{{route('admin.products.index')}}">Produtos</a>
              </li>
            @endif
          </ul>
          <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
              @if (auth()->user()->unreadNotifications->count())
                <li class="nav-item @if(request()->is('admin/notifications*')) active @endif">              
                  <a class="nav-link" href="{{route('admin.notifications')}}">
                    <span class="badge badge-danger">{{auth()->user()->unreadNotifications->count()}}</span>
                    <i class="fa fa-bell"></i>
                  </a>
                </li>
              @endif
              <li class="nav-item">
                <span class="nav-link">{{auth()->user()->name}}</span>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.querySelector('form.logout').submit();">Sair</a>
                <form action="{{route('logout')}}" class="logout" method="POST">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
        @endauth
    </nav>
    <div class="container">
        @include('flash::message')
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>
<body>
    <div id="divtitulo"><a href="{{ url('/')}}">
        <h1 id="titulo">C-ARTE <small>vendemos arte</small></h1></a>
    </div>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header"></div>
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endif
                            
                            @if (Auth::check())
                                <li><a href="{{ url('/home') }}">Home</a></li>
                            @endif

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  Categorias <span class="caret"></span>
                                </a>
                               <ul class="dropdown-menu">

                                   @foreach($categorias as $categoria)
                                   <a class="enlacedesplegable" href="{{ route('categorias.show', [$categoria->slug])}}">{{ $categoria->name}}</a></li><br>
                                   @endforeach
                               </ul>
                            </li>

                            <li>
                                <form class="navbar-form navbar-left pull-left" role="search" method="GET" action="{{route('search')}}">
                                    <div class="form-group">
                                         <input type="text" class="form-control" name="word" placeholder="Search">
                                    </div>
                                    <button type="submit" class="btn btn-default">Buscar</button>
                                </form>
                            </li>

                            @if (!Auth::guest())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a class="enlacedesplegable" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                 Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li>
                                        <a class="enlacedesplegable" href="{{ route('user/edit') }}">
                                           Editar Perfil
                                        </a>

                                        <form id="edit-form"  action="{{ route('user/edit') }}" method="POST" style="display: none;">   
                                        </form>
                                    </li>
                                    <li>
                                        <a class="enlacedesplegable" href="{{ route('user/delete') }}">
                                            Borrar Perfil
                                        </a>

                                        <form id="delete-form"  action="" method="POST" style="display: none;">

                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        @yield('content')
        </div>
        <div id="footer">
            <div class="container" id="contenedorpie">
                <p class="text-muted credit"> <a href="{{ route('tiendascerca')}}">Tiendas cerca</a> </p>
                <p class="text-muted credit"> <a href="">Contacto</a> </p>
                <p class="text-muted credit"> <a href="">Privacidad</a></p>
                <p class="text-muted credit"> <a href="">Condiciones de uso</a></p>
            </div>
        </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

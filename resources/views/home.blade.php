@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            @if (Session::has('mensaje'))
                <p class="alert alert-succes">{{ Session::get('mensaje') }} </p>
            @endif
            
            {{Session::forget('mensaje')}}
            
            @if (!Session::has('busqueda'))
                <a class="botonordenar" href="{{ route('ordenarprecio') }}">Ordenar por precio</a>
                <a class="botonordenar" href="{{ route('ordenarpornombre') }}">Ordenar por orden alfabetico</a>
            @else 
                {{Session::forget('busqueda')}}
                {{Session::forget('mensaje')}}
            @endif
            
            <div class="panel-body">
                <p>
                    {{ $productos->total() }} productos |
                    página {{ $productos->currentPage() }}
                    de {{ $productos->lastPage() }}   
                </p> 
                <div class="divproductos">
                    @foreach($productos as $item)
                        @foreach($categorias as $categoria)
                            @if($categoria->id == $item->categoria_id)
                                <div class="contenedorproductos">
                                    <a href="{{ route('categorias.productos.show', [$categoria->slug, $item->slug]) }}"><h3>{{ $item->name }}</h3>
                                    <div class="contenedorimagen"><img width="150px" height="150px" src="{{ $item->img }}" class="img-responsive" /></a></div>
                                    @if( Auth::check())
                                    <div class="contenedorprecio"><h3>Precio anterior: {{$item->precio}}€</h3></div><br>
                                        Descuento: {{ $item->descuento}}%<br>
                                        <h3 class="contenedorpreciopromo">Precio promocional: {{ $item->preciopromocional }}€</h3><br>
                                    @else
                                    <h3>Precio: {{$item->precio}}€<h3><br>
                                    @endif
                                    
                                    Unidades disponibles: {{$item->unidades}}<br>
                                    </div>
                            @endif
                        @endforeach  
                    @endforeach
                </div>
                {!! $productos->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

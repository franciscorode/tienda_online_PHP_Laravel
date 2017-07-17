@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            @if (Session::has('mensaje'))
                 <p class="alert alert-succes">{{ Session::get('mensaje') }} </p>
            @endif
            
            <a class="botonordenar" href="{{ route('ordenarpreciocategoria') }}?id={{$categoria->id}}">Ordenar por precio</a>
            <a class="botonordenar" href="{{ route('ordenarpornombrecategoria') }}?id={{$categoria->id}}">Ordenar por orden alfabetico</a>
            <div class="panel-body">
                <p>
                    {{ $productos->total() }} productos |
                    página {{ $productos->currentPage() }}
                    de {{ $productos->lastPage() }}   
                </p>
                 <div id="divproductos">
                    @foreach($productos as $item)

                        <div class="contenedorproductos">
                            <a href="{{ route('categorias.productos.show', [$categoria->slug, $item->slug]) }}"><h3>{{ $item->name }}</h3>
                            <div class="contenedorimagen"><img width="150px" height="150px" src="{{ $item->img }}" class="img-responsive" /></a></div>

                            @if( Auth::check())
                                <div class="contenedorprecio">Precio anterior: {{$item->precio}}€</div><br>
                                Descuento: {{ $item->descuento}}%<br>
                                <h3 class="contenedorpreciopromo">Precio promocional: {{ $item->preciopromocional }}€</h3><br>
                            @else
                                <h3>Precio: {{$item->precio}}€</h3><br>
                            @endif

                            Unidades disponibles: {{$item->unidades}}<br>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {!! $productos->links() !!}
    </div>
</div>
@endsection
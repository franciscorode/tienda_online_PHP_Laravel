@extends('layouts.app')

@section('content')
    <div class="row" id="panel">
        @if (Session::has('mensaje'))
            <p class="alert alert-succes">{{ Session::get('mensaje') }} </p>
        @endif
        {{Session::forget('mensaje')}}
        <div class="panel panel-default">
            
            <div class="panel-body">
                <p>  
                    {{ $productos->total() }} productos |
                    página {{ $productos->currentPage() }}
                    de {{ $productos->lastPage() }} 
                </p>
                <h3 id="titulodestacados">Productos destacados</h3>
                <div id="tablaproductos">
                    @foreach($productos as $item)
                        @foreach($categorias as $categoria)
                            @if($categoria->id == $item->categoria_id)
                                <div class="contenedorproductos">
                                <a href="{{ route('categorias.productos.show', [$categoria->slug, $item->slug]) }}"><h3>{{ $item->name }}</h3>
                                <div class="contenedorimagen"><img width="150px" height="150px" src="{{ $item->img }}" class="img-responsive" /></a></div>
                            
                                @if( Auth::check())
                                    <div class="contenedorprecio">Precio anterior: {{$item->precio}}€</div><br>
                                    Descuento: {{ $item->descuento}}%<br>
                                    <h4 class="contenedorpreciopromo">Precio promocional: {{ $item->preciopromocional }}€</h4><br>
                                @else
                                <h3>Precio: {{$item->precio}}€</h3><br>
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
@endsection
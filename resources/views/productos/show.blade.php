@extends('layouts.app')

@section('content')
<div class="container" id="divproducto">
    <h2>{{$producto->name}}</h2>
    <img height="300px" width="300px" src="{{ $producto->img}}">
    <h3>{{$producto->description}}</h3>
    
    @if( Auth::check())
        <div class="contenedorprecio">Precio anterior: {{$producto->precio}}€</div><br>
        Descuento: {{ $producto->descuento}}%<br>
        <h2 class="contenedorpreciopromo">Precio promocional: {{ $producto->preciopromocional }}€</h2><br>
    @else
    <h3>Precio: {{$producto->precio}}€<h3><br>
    @endif
    
    <h3>Unidades disponibles: {{$producto->unidades}}</h3>
</div>
@endsection
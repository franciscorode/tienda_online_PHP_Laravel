<!-- /resources/views/categorias/index.blade.php -->
@extends('app')
 
@section('content')
    <h2>categorias</h2>
 
    @if ( !$categorias->count() )
    <h3>No hay categorias</h3>
    @else
        <ul>
            @foreach( $categorias as $categoria )
                <li>
                    {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('categorias.destroy', $categoria->slug))) !!}
                        <a href="{{ route('categorias.show', $categoria->slug) }}">{{ $categoria->name }}</a>
                        (
                            {!! link_to_route('categorias.edit', 'Editar', array($categoria->slug), array('class' => 'btn btn-info')) !!},
                            {!! Form::submit('Borrar', array('class' => 'btn btn-danger')) !!}
                        )
                    {!! Form::close() !!}
                </li>
            @endforeach
        </ul>
    @endif
 
    <p>
        {!! link_to_route('categorias.create', 'Crear Categoria') !!}
    </p>
@endsection
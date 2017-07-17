@extends('app')
 
@section('content')
    <h2>Crear Categoria</h2>
 
    {!! Form::model(new App\categoria, ['route' => ['categorias.store'],'files' => true]) !!}
        @include('categorias/partials/_form', ['submit_text' => 'Crear Categoria'])
    {!! Form::close() !!}
@endsection
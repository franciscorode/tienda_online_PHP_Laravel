@extends('app')

@section('content')
<h2>Editar Categoria</h2>

{!! Form::model($categoria, ['method' => 'PATCH', 'route' => ['categorias.update', $categoria->slug],'files' => true]) !!}
@include('categorias/partials/_form', ['submit_text' => 'Editar Categoria'])
{!! Form::close() !!}
@endsection

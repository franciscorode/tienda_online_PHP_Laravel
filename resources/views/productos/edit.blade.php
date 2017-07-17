@extends('app')
 
@section('content')
    <h2>Editar Producto "{{ $task->name }}"</h2>
 
    {!! Form::model($task, ['method' => 'PATCH', 'route' => ['Categorias.tasks.update', $Categoria->slug, $task->slug],'files' => true]) !!}
        @include('tasks/partials/_form', ['submit_text' => 'Editar Producto'])
    {!! Form::close() !!}
@endsection

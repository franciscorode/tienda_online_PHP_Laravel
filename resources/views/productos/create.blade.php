<!-- /resources/views/tasks/create.blade.php -->
@extends('app')
 
@section('content')
    <h2>Crear producto para la categoria "{{ $Categoria->name }}"</h2>
 
    {!! Form::model(new App\Task, ['route' => ['Categorias.tasks.store', $Categoria->slug], 'class'=>'', 'files' => true]) !!}
        @include('tasks/partials/_form', ['submit_text' => 'Create Task'])
    {!! Form::close() !!}
@endsection
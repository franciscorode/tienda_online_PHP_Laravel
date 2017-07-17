@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edita la informacion de tu cuenta {{ $user->name }}</div>
                <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <form action="{{ route('edit/autocompletar') }}" method="GET">
                                    <input type="submit" name="autocompletar" value="Autocompletar con google+">
                                        
                                </form>
                            </div>
                        </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ route('user/save') }}">
                        <div class="form-group">
                            <label for="foto" class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                @if(Session::has('foto'))
                                <img width="150px" height="150px" src="{{Session::get('foto')}}" name="foto" id="foto">
                                <input type="hidden" name="foto" id="foto" value="{{Session::get('foto')}}"/>
                                @else 
                                <img width="150px" height="150px" src="{{$user->foto }}" name="foto" id="foto">
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                @if(Session::has('name'))
                                <input id="name" type="text" class="form-control" name="name" value="{{Session::get('name')}}">
                                @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                                @endif
       
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('') ? ' has-error' : '' }}">
                            <label for="apellidos" class="col-md-4 control-label">Apellidos</label>
                            <div class="col-md-6">
                                 @if(Session::has('apellidos'))
                                <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{Session::get('apellidos')}}">
                                @else
                                <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{ $user->apellidos}}">
                                @endif
                            </div>
                        </div>
                        
                        <div  class="form-group{{ $errors->has('pais') ? ' has-error' : '' }}">
                            <label for="pais" class="col-md-4 control-label">Pais</label>

                            <div class="col-md-6">
                                <select name="pais" id="pais" value="{{$user->pais}}">
                                    <option value="elige">--elige--</option> 
                                    <option <?php if($user->pais == "España"){ echo "selected";}?> value="España">España</option> 
                                    <option <?php if($user->pais == "Francia"){ echo "selected";}?> value="Francia">Francia</option>
                                    <option <?php if($user->pais == "Inglaterra"){ echo "selected";}?> value="Inglaterra">Inglaterra</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                @if(Session::has('email+'))
                                <input id="email" type="email" class="form-control" name="email" value="{{Session::get('email+')}}" required autofocus >
                                @else
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required autofocus>
                                @endif

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        </div>-->

                        <div class="form-group{{ $errors->has('interes') ? ' has-error' : '' }}">
                            <label for="interes" class="col-md-4 control-label">Categoria de interes</label>
                            <select name="interes" id="interes" value="{{$user->interes}}">
                                    <option value="elige">--elige--</option> 
                                    <option <?php if($user->interes == "cuadros"){ echo "selected";}?> value="cuadros">cuadros</option> 
                                    <option <?php if($user->interes == "ceramica"){ echo "selected";}?> value="ceramica">ceramica</option>
                                    <option <?php if($user->interes == "graffiti"){ echo "selected";}?> value="graffiti">graffiti</option>
                                    <option <?php if($user->interes == "esculturas"){ echo "selected";}?> value="esculturas">esculturas</option>
                                    <option <?php if($user->interes == "dibujos"){ echo "selected";}?> value="dibujos">dibujos</option>

                                </select>
                        </div>  
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

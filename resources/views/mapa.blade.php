@extends('layouts.app')

@section('content')
<div class="container" height="800px" id="divmapa">
    <div class="row">
        <div class="panel panel-default">
            <article id="productosencontradosmapa">
                <h2 class="tituloresultados" >MAPA </h2>
                <input type="hidden" id="latitud" name="latitud" value="{{$coordenadas_region['lat']}}"/>
                <input type="hidden" id="longitud" name="longitud" value="{{$coordenadas_region['lng']}}"/>
                <div id="mapageo">
                    <h2 class="tituloresultados">Su navegador no soporta el mapa o no le ha dado permisos</h2>
                </div>
            </article>
        </div>
    </div>
    <script src="{{ asset('js/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCDZ4035anJ_0uoqAuF88QmcuqAWQBzaY"
        async defer></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</div>
@endsection


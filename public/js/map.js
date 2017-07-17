
function drawMap(latlng) {
     //recogemos las corrdenadas de la tienda recibidas por el servidor
    var latitud = document.getElementById("latitud").value;
    var longitud = document.getElementById("longitud").value;
    var options = {zoom: 14, center: {lat: parseFloat(latitud), lng: parseFloat(longitud)}};

    //Creamos el mapa
    var map = new google.maps.Map(document.getElementById("mapageo"), options);

    //recogemos las corrdenadas de la tienda recibidas por el servidor
    var latitud = document.getElementById("latitud").value;
    var longitud = document.getElementById("longitud").value;
    //creamos el marcador
    var marker = new google.maps.Marker({
        position: {lat: parseFloat(latitud), lng: parseFloat(longitud)},
        map: map,
        title: "Nuestra tienda"
    });

    //insertamos el marcador en el mapa
    marker.setMap(map);
    
    var defaultLatLng = new google.maps.latlng(34.0983425, -118.3267434);
}



function init_map() {
    if (navigator.geolocation) {
        function success(pos) {
            drawMap(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
        }

        function fail(error) {
            var defaultLatLng = new google.maps.LatLng(40.5683621, -3.5890299999999797);
            drawMap(defaultLatLng);
        }
        navigator.geolocation.getCurrentPosition(success, fail);
    } else {
        drawMap(defaultLatLng);
    }
}
window.onload = function () {
    init_map();
};
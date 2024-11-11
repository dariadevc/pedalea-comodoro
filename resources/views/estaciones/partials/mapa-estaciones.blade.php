<div id="map" class="w-full h-full"></div>

<!-- Cargar el CSS y JS de Leaflet sin el atributo integrity -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const map = L.map('map').setView([{{ $estaciones->first()->latitud ?? 0 }}, {{ $estaciones->first()->longitud ?? 0 }}], 13);


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach($estaciones as $estacion)
            L.marker([{{ $estacion->latitud }}, {{ $estacion->longitud }}])
                .addTo(map)
                .bindPopup(`
                    <strong>{{ $estacion->nombre }}</strong><br>
                    Bicicletas disponibles: {{ $estacion->cantidad_bicicletas_disponibles ?? 0 }}
                `);
        @endforeach
    });
</script>

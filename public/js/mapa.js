// Inicializar el mapa centrado en Comodoro Rivadavia
var map = L.map('mapa').setView([-45.8645, -67.4796], 13); // Coordenadas de Comodoro

// Añadir la capa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Petición Fetch para obtener las estaciones
fetch('/estacionesMapa', {
    method: 'GET',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
.then(response => response.json())
.then(data => {
    data.forEach(estacion => {
        L.marker([estacion.latitud, estacion.longitud]).addTo(map)
        .bindPopup(`
            <strong>${estacion.nombre}</strong><br>
            Bicicletas disponibles: ${estacion.cantidad_bicicletas_disponibles}
        `);
    });
})
.catch(error => console.error('Error fetching estaciones:', error));

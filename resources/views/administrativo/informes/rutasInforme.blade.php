<div class="background-container"></div>
<div class="container mx-auto mt-6">
    <h3 class="text-3xl font-bold mb-4 text-center text-black title-section">Informes de Rutas</h3>
    <form method="GET" action="{{ route('informes.rutas') }}" class="bg-sky-100 p-6 rounded shadow-md">
        <label for="fecha_inicio">Desde:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required value="{{ $fechaInicio ?? '' }}">
        <label for="fecha_fin">Hasta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required value="{{ $fechaFin ?? '' }}">
        <button type="submit" class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded">Generar
            Informe</button>
    </form>
</div>

<br>

<div class="container mx-auto mt-6">
    @if (isset($rutas) && count($rutas) > 0)
        <h1 class="text-2xl font-bold mb-4 text-black title-section">Listado de Rutas</h1>
        <canvas id="rutasChart" width="400" height="200"></canvas>
    @else
        <p class="mt-6 text-center text-gray-500">No hay datos disponibles para el rango de fechas seleccionado.</p>
    @endif
</div>
<br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('rutasChart').getContext('2d');
    var alquilerChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($rutas->pluck('rutas')) !!},
            datasets: [{
                label: 'Cantidad de Veces',
                data: {!! json_encode($rutas->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                x: {
                    display: false
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

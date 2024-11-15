<div class="background-container"></div>
<div class="container mx-auto mt-6">
    <h3 class="text-3xl font-bold mb-4 text-center text-pc-texto-h">Informe de Rutas</h3>
    <form method="GET" action="{{ route('informes.rutas') }}"
        class="border-2 border-gray-100 p-6 rounded-lg shadow-md flex justify-center items-center gap-4">
        <label for="fecha_inicio">Desde:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio"
            value="{{ old('fecha_inicio', request('fecha_inicio')) }}" required>

        <label for="fecha_fin">Hasta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', request('fecha_fin')) }}"
            required>

        <button type="submit" class="bg-pc-azul hover:bg-pc-celeste text-white font-bold py-2 px-4 rounded">Generar
            Informe</button>
    </form>
</div>

<br>

<div class="container mx-auto mt-6">
    @if (isset($rutas) && count($rutas) > 0)
        <h1 class="text-2xl font-bold mb-4 text-black title-section">Grafico de Rutas</h1>
        <p class="text-center text-gray-600 mb-4">Este gráfico muestra la cantidad de veces que cada ruta ha sido utilizada durante el período seleccionado.</p>
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
                label: 'Cantidad de veces utilizadas',
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

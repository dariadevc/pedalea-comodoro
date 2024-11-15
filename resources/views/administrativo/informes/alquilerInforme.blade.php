<div class="container mx-auto mt-6">
    <h1 class="text-3xl font-bold mb-4 text-center text-pc-texto-h">Informe de Alquileres</h1>
    <form method="GET" action="{{ route('informes.tiempoHorario') }}"
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
    @if (isset($alquileresHor) && count($alquileresHor) > 0)
        <h1 class="text-2xl font-bold mb-4 text-black title-section">Grafico de tiempos de alquiler</h1>
        <p class="text-center text-gray-600 mb-4">Este gráfico muestra la cantidad de veces que un cierto tiempo ha sido utilizado durante el período seleccionado.</p>
        <canvas id="alquilerChart" width="400" height="200"></canvas>
        <br>
        <h1 class="text-2xl font-bold mb-4 text-black title-section">Listado de horarios de alquiler</h1>

        <table class="min-w-full border-collapse block md:table">
            <thead class="block md:table-header-group">
                <tr
                    class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                    <th
                        class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">
                        Horarios de alquiler</th>
                    <th
                        class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">
                        Cantidad de veces utilizada</th>
                    <th
                        class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">
                        Porcentaje de clientes</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($alquileresHor as $alquilerHor)
                    <tr class="bg-sky-50 border border-grey-500 md:border-none block md:table-row">
                        <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $alquilerHor->hora }}
                        </td>
                        <td class="p-2 md:border md:border-black text-left block md:table-cell">
                            {{ $alquilerHor->cant_horas }}</td>
                        <td class="p-2 md:border md:border-black text-left block md:table-cell">
                            {{ $alquilerHor->porcentaje }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-6 text-center text-gray-500">No hay datos disponibles para el rango de fechas seleccionado.</p>
    @endif
</div>
<br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('alquilerChart').getContext('2d');
    var alquilerChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($alquileresTime->pluck('tiempo')) !!},
            datasets: [{
                label: 'Cantidad de veces utilizado',
                data: {!! json_encode($alquileresTime->pluck('cant')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

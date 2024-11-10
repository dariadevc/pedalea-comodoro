@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historial de Reservas</h1>
        <br>
        <!--Aca se ingresa la fecha desde y la fecha hasta, si no ingresa las 2 no puede obtener reservas.-->
        <form method="GET" action="{{ route('historiales.reservas') }}">

            <div class="form-group">
                <label for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required value="{{ $fechaInicio ?? '' }}">
            
                <label for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required value="{{ $fechaFin ?? '' }}">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        @if($reservas->count() > 0)
            <h2 class="mt-4">Resultados de la Búsqueda</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Bicicleta</th>
                        <th>Estación de Retiro</th>
                        <th>Estación de Devolución</th>
                        <th>Fecha de Retiro</th>
                        <th>Fecha de Devolución</th>
                        <td>Puntaje Obtenido</td>
                    </tr>
                </thead>
                <tbody>
                    <!--Recorro las reservas y muestro todos sus datos al cliente-->
                    @foreach($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->estado}}</td>
                            <td>{{ $reserva->bicicleta_patente }}</td>
                            <td>{{ $reserva->estacion_retiro_nombre }}</td>
                            <td>{{ $reserva->estacion_devolucion_nombre }}</td>
                            <td>{{ $reserva->fecha_hora_retiro }}</td>
                            <td>{{ $reserva->fecha_hora_devolucion }}</td>
                            <td>{{ $reserva->puntaje}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
            <!--Linea nesesaria para que aparezca las diferentes paginas que se puede ingresar para ver las reservas-->
            {{ $reservas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links()  }}
            </div>
        @else
            <p>No se encontraron reservas en el rango de fechas especificado.</p>
        @endif
    </div>
@endsection



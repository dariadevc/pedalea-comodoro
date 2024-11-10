@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historial de Multas</h1>
        <br>
        <!--Aca se ingresa la fecha desde y la fecha hasta, si no ingresa las 2 no puede obtener reservas.-->
        <form method="GET" action="{{ route('historiales.multas') }}">
            <div class="form-group">
                <label for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required value="{{ $fechaInicio ?? '' }}">
            
                <label for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required value="{{ $fechaFin ?? '' }}">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        @if($multas->count() > 0)
            <h2 class="mt-4">Resultados de la Búsqueda</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Fecha y Hora</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <!--Recorro las multas y muestro todos sus datos al cliente-->
                    @foreach($multas as $multa)
                        <tr>
                            <td>{{ $multa->estadoName}}</td>
                            <td>{{ $multa->monto }}</td>
                            <td>{{ $multa->fecha_hora }}</td>
                            <td>{{ $multa->descripcion}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
            <!--Linea nesesaria para que aparezca las diferentes paginas que se puede ingresar para ver las reservas-->
            {{ $multas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links()  }}
            </div>
        @else
            <p>No se encontraron reservas en el rango de fechas especificado.</p>
        @endif
    </div>
@endsection

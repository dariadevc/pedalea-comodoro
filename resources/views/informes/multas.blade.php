@extends('layouts.app')

@section('content')
    <h1>Informe de Multas:</h1>
    <br>
    <form method="GET" action="{{ route('informes.multas') }}">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required>
        
        <button type="submit">Generar Informe</button>
    </form>
    <br>
    
    @if(isset($multas) && count($multas) > 0)
        <h2>Listado de Multas:</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Fecha y Hora</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($multas as $multa)
                    <tr>
                        <td>{{ $multa->nombre_usuario}}</td>
                        <td>{{ $multa->monto }}</td>
                        <td>{{ $multa->fecha_hora }}</td>
                        <td>{{ $multa->descripcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron multas en este rango de fechas.</p>
    @endif
@endsection





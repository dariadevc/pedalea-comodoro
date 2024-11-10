@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historial de Movimientos</h1>
        <br>
         <!--Creo que ya no hace falta esta linea porque en este consultar no nesesita las fechas, solo mostrarle todo los mov
        de forma paginada.-->
        <form method="GET" action="{{ route('historiales.movimientos') }}">
        </form>

        @if($movimientos->count() > 0)
            <h2 class="mt-4">Actividad de Saldo</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th>Monto</th>
                        <th>Fecha Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <!--Recorro los movimientos y muestro todos sus datos al cliente-->
                    @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->motivo}}</td>
                            <td>{{ $movimiento->monto }}</td>
                            <td>{{ $movimiento->fecha_hora }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
            <!--Linea nesesaria para que aparezca las diferentes paginas que se puede ingresar para ver las reservas-->
            {{ $movimientos->links() }}
            </div>
        @else
            <p>No se encontraron reservas en el rango de fechas especificado.</p>
        @endif
    </div>
@endsection

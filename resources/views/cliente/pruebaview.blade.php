<!DOCTYPE html>
<html>
<head>
    <title>Vista de Objetos</title>
</head>
<body>
    <h1>Lista</h1>

    <ul>
        <h1>Estaciones disponibles en ese horario de retiro</h1>
        {{-- $estacionesDisponibles, es un array de los objetos estaciones, que son las estaciones disponibles en ese horario de retiro, es decir, las estaciones que tienen bicicletas no-reservadas en el horario de retiro ingresado por el usuario --}}

        @foreach ($estacionesDisponibles as $estacion)
        <p>ID de la estación: {{ $estacion->id_estacion }}</p>
    @endforeach

    </ul>
</body>
</html>

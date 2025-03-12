$(document).ready(function() {
    // Cargar cada informe dinámicamente al hacer clic en un botón
    $('.informes-btn').on('click', function(event) {
        event.preventDefault(); // Evita la recarga de la página

        const url = $(this).data('url'); // URL del informe desde data-url

        // Cargar el contenido del informe en el contenedor
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                // Coloca el contenido en #contenedor-informe
                $('#contenedor-informe').html(data);
                console.log("Informe cargado en contenedor-informe");
            },
            error: function(xhr) {
                console.error("Error al cargar el contenido del informe: ", xhr.responseText);
            }
        });
    });

    // Evento para capturar la selección de fechas en cualquier informe cargado dinámicamente
    $(document).on('submit', '#contenedor-informe form', function(event) {
        event.preventDefault();

        const formUrl = $(this).attr('action');
        const fechaInicio = $(this).find('#fecha_inicio').val();
        const fechaFin = $(this).find('#fecha_fin').val();

        // Realizar la solicitud AJAX con las fechas
        $.ajax({
            url: formUrl,
            method: 'GET',
            data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
            success: function(data) {
                // Actualiza solo el contenido del informe (tabla, gráfico, etc.)
                $('#contenedor-informe').html(data);
                console.log("Informe actualizado con fechas");
            },
            error: function(xhr) {
                console.error("Error al cargar el informe con fechas: ", xhr.responseText);
            }
        });
    });
});


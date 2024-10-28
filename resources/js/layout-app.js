import $ from 'jquery';
window.$=$;

$(document).ready(function() {
    // Selecciona todos los enlaces que deberían cargar contenido dinámico
    $('.nav-link').on('click', function(event) {
        event.preventDefault(); // Evita la recarga de la página

        const url = $(this).attr('href'); // Obtiene la URL del enlace

        // Realiza la solicitud AJAX
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                // Reemplaza el contenido del main con la respuesta
                $('#main').html(data);
                console.log("Contenido actualizado en el main");
            },
            error: function(xhr) {
                console.error("Error al cargar el contenido: ", xhr.responseText);
            }
        });
    });
});
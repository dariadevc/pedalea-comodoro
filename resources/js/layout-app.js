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

// function cargarPartial(url) {
//     $.ajax({
//         url: url,
//         method: 'GET',
//         success: function(data) {
//             $('#main').html(data);
//         },
//         error: function(xhr) {
//             alert('Error: ' + xhr.responseText);
//         }
//     });
// }

// $(document).ready(function() {
//     $('.nav-link').on('click', function(e) {
//         e.preventDefault(); // Evita que el enlace recargue la página

//         var url = $(this).data('url'); // Obtiene la URL del atributo data-url
//         cargarPartial(url); // Llama a la función para cargar el partial
//     });
// });
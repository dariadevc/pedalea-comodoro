import $ from 'jquery';
window.$ = $;


window.mostrarFormularioDanios = function (event) {
    event.preventDefault();

    // Realiza la solicitud AJAX
    $.ajax({
        url: $('#formularioMostrarDanios').attr('action'),
        method: $('#formularioMostrarDanios').attr('method'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#contenedorConsultaDanios').remove();
            $('#contenedorFormularioDanios').html(response.html);
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    });
};

window.sinDanios = function (event) {
    event.preventDefault();

    $.ajax({
        url: $('#formularioSinDanios').attr('action'),
        method: $('#formularioSinDanios').attr('method'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#contenedorConsultaDanios').remove();
            $('#contenedorCalificarEstaciones').html(response.html);
            manejarClickEstrellas('retiro');
            manejarClickEstrellas('devolucion');
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    });
};


function setEstrellasSeleccionadas(tipo, valor) {
    const estrellas = $(`.estrella.${tipo}`);
    estrellas.each(function (index) {
        if (index < valor) {
            $(this).find('path').css('fill', '#FFD700'); // Cambiar a color dorado para selección
        } else {
            $(this).find('path').css('fill', 'none'); // Restaurar el color para no seleccionadas
        }
    });

    // Opcional: Añadir clase activa para mayor control
    estrellas.removeClass('active');
    estrellas.slice(0, valor).addClass('active');
}


function manejarClickEstrellas(tipo) {
    $(`.estrella.${tipo}`).on('click', function () {
        const valor = $(this).data('valor');
        setEstrellasSeleccionadas(tipo, valor);
        $(`#inputCalificacion${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`).val(valor);
    });
}




window.guardarDanios = function (event) {
    event.preventDefault();

    // Realiza la solicitud AJAX
    $.ajax({
        url: $('#formularioDanios').attr('action'),
        method: $('#formularioDanios').attr('method'),
        data: $('#formularioDanios').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#contenedorFormularioDanios').remove();
            $('#contenedorCalificarEstaciones').html(response.html);
            manejarClickEstrellas('retiro');
            manejarClickEstrellas('devolucion');

        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let mensaje = errors ? Object.values(errors).join('. ') : "Ocurrió un error al procesar la solicitud.";
                $('#error-danios').text(mensaje).show();
            }
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    });
};




window.guardarCalificacion = function (event) {
    event.preventDefault();
    $('#error-calificacion_devolucion').empty();
    $('#error-calificacion_retiro').empty();
    // Realiza la solicitud AJAX
    $.ajax({
        url: $('#formularioCalificacion').attr('action'),
        method: $('#formularioCalificacion').attr('method'),
        data: $('#formularioCalificacion').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#contenedorCalificarEstaciones').remove();
            $('#contenedorDevolucion').html(response.html);
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let campo in errors) {
                    let mensaje = errors[campo].join(', ');
                    $(`#error-${campo}`).text(mensaje).show(); // Asegúrate de tener un elemento para mostrar errores
                }
            }
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    });
};

import $ from 'jquery';
window.$ = $;


// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

window.cargarPaso = function (paso) {
    $.ajax({
        url: urlPasos,
        method: 'POST',
        data: { paso: paso },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (html) {
            $('#contenedor-pasos').html(html);
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    })
}
$(document).ready(function () {
    window.cargarPaso('1');
});

window.traerEstacionesDisponibles = function () {
    var datos = $('#formularioHorarioRetiro').serialize();

    $.ajax({
        url: $('#formularioHorarioRetiro').attr('action'),
        type: $('#formularioHorarioRetiro').attr('method'),
        data: datos,
        success: function (response) {
            if (response.success) {
                window.activarFormularioDatosReserva(response);
            }
        },
        error: function (response) {
            console.log('Hubo un error al enviar el formulario');
        },
    });
};


window.agregarOpcionesRetiro = function (response) {
    $('#estacion_retiro').prop('disabled', false);

    $('#estacion_retiro').empty();

    $('#estacion_retiro').append('<option value="" selected>Seleccione una opción</option>');

    response.estaciones_disponibles.forEach(function (estacion) {
        $('#estacion_retiro').append('<option value="' + estacion.id_estacion + '">' + estacion.nombre + '</option>');
    });
}
window.agregarOpcionesDevolucion = function (response) {
    $('#estacion_devolucion').prop('disabled', false);

    $('#estacion_devolucion').empty();

    $('#estacion_devolucion').append('<option value="" selected>Seleccione una opción</option>');

    response.estaciones_devolucion.forEach(function (estacion) {
        $('#estacion_devolucion').append('<option value="' + estacion.id_estacion + '">' + estacion.nombre + '</option>');
    });
}
window.activarFormularioDatosReserva = function (response) {


    if (response.estaciones_disponibles.length === 0) {
        $('#errorHorarioRetiro').prop('disabled', false);
        $('#errorHorarioRetiro').append('No hay bicicletas disponibles para el horario seleccionado. Seleccione nuevamente otro horario.')
    } else {
        $('#errorHorarioRetiro').prop('disabled', true);
        $('#errorHorarioRetiro').empty();
        window.agregarOpcionesDevolucion(response);
        window.agregarOpcionesRetiro(response);
        $('#tiempo_uso').prop('disabled', false);
    }
}


// // // ----------------

window.mandarFormularioDatosReserva = function () {
    let horario_retiro = $('#horario_retiro').val();
    $('#horario_retiro_reserva').val(horario_retiro);
    $('.error-message').text('');

    $.ajax({
        url: $('#formularioDatosReserva').attr('action'),
        method: $('#formularioDatosReserva').attr('method'),
        data: $('#formularioDatosReserva').serialize(),
        success: function (response) {
            window.cargarPaso('2');
        },
        error: function (xhr, status, error) {
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response:', xhr.responseText);
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                if (errors.estacion_retiro) {
                    $('#error-estacion-retiro').text(errors.estacion_retiro.join(', '));
                }
                if (errors.estacion_devolucion) {
                    $('#error-estacion-devolucion').text(errors.estacion_devolucion.join(', '));
                }
                if (errors.tiempo_uso) {
                    $('#error-tiempo-uso').text(errors.tiempo_uso.join(', '));
                }
            } else {
                alert('Hubo un error inesperado. Intenta de nuevo.');
            }
        }
    });
}

// // // ---------



window.enviarFormularioDatosCorrectos = function () {
    var form = $('#formularioDatosCorrectos');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response) {
                window.cargarPaso('3');
            }
        },
        error: function (response) {
            console.log('Error al enviar Formulario Datos Correctos');
        }
    });
}

window.enviarFormularioDatosIncorrectos = function () {
    var form = $('#formularioDatosIncorrectos');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response) {
                window.location.href = response.redirect;
            }
        },
        error: function (response) {
            console.log('Error al enviar Formulario Datos Incorrectos');
        }
    });
}

window.enviarFormularioPagarReserva = function () {
    var form = $('#formularioPagarReserva');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                alert(response.mensaje);
                window.location.href = response.redirect;
            } else {
                window.toggleModal();
            }
        },
        error: function (xhr, status, error) {
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
}

window.toggleModal = function () {
    $('#modalConfirmacion').toggleClass('invisible');
}

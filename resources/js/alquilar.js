import $ from 'jquery';
window.$ = $;


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



window.mandarFormularioBiciDisponible = function () {
    var datos = $('#formularioBiciDisponible').serialize();

    $.ajax({
        url: urlBiciDisponible,
        type: 'POST',
        data: datos,
        success: function (response) {
            if (response.success) {
                window.ocultarDisponible();
                window.mostrarPagarAlquiler();
            }
        },
        error: function (response) {
            console.log('Hubo un error al enviar el formulario');
        },
    });
};
window.mandarFormularioBiciNoDisponible = function () {
    var datos = $('#formularioBiciNoDisponible').serialize();

    $.ajax({
        url: urlBiciNoDisponible,
        type: 'POST',
        data: datos,
        success: function (response) {
            if (response.success) {
                window.ocultarDisponible();
                window.mostrarPagarAlquiler();
            } else {

                /**
                 * 
                 * FALTA REALIZAR LA LOGICA DE MOSTRAR SI QUIERE QUE SE LO MODIFIQUE LA RESERVA ACTUAL
                 * 
                 */

                alert(response.mensaje);
            }
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }
    });
};

window.mandarFormularioPagar = function (valorBoton) {
    console.log(valorBoton);
    $('#pagar').val(valorBoton);

    if (valorBoton === "") {
        alert("Por favor, seleccione pagar.");
        return;
    }

    var datos = $('#formularioPagar').serialize();
    console.log(datos);

    $.ajax({
        url: urlPagar,
        type: 'POST',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                alert(response.mensaje);
                window.location.href = response.redirect;
            } else {
                alert(response.mensaje);
            }
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }

    });
};

window.ocultarDisponible = function () {
    $('#contenedorDisponibilidad').removeClass('flex').addClass('hidden');
}

window.mostrarPagarAlquiler = function () {
    $('#contenedorPagarAlquiler').removeClass('hidden');
}

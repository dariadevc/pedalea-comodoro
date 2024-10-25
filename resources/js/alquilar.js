import $ from 'jquery';
window.$ = $;


window.mandarFormularioDisponibilidad = function(valorBoton) {
    $('#bicicletaDisponible').val(valorBoton);
    
    // Verificar si se ha seleccionado una opción
    if (valorBoton === "") {
        alert("Por favor, seleccione si la bicicleta está disponible o no.");
        return;
    }

    var datos = $('#formularioDisponibilidad').serialize();

    $.ajax({
        url: urlAlquilar,
        type: 'POST',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
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

window.mandarFormularioPagar = function(valorBoton) {
    $('#pagar').val(valorBoton);
    
    // Verificar si se ha seleccionado una opción
    if (valorBoton === "") {
        alert("Por favor, seleccione pagar.");
        return;
    }

    var datos = $('#formularioPagarAlquiler').serialize();

    $.ajax({
        url: urlPagar,
        type: 'POST',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                console.log('Anda');
            }
        },
        error: function (response) {
            console.log('Hubo un error al enviar el formulario');
        },
    });
};

window.ocultarDisponible = function () {
    $('#contenedorDisponibilidad').removeClass('flex').addClass('hidden');
}

window.mostrarPagarAlquiler = function () {
    $('#contenedorPagarAlquiler').removeClass('hidden');
}


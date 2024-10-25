import $ from 'jquery';
window.$ = $;


window.mandarFormularioDisponibilidad = function(valorBoton) {
    $('#bicicletaDisponible').val(valorBoton);
    
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
                console.log('Anda');
            } else {
                console.log('Hubo un error al pagar');
                alert('Hubo un error al pagar');
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


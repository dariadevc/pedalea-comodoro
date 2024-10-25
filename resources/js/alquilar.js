import $ from 'jquery';
window.$ = $;


$(document).ready(function () {
    $('input[type=button]').on('click', function() {
        var disponibilidad = $(this).val();
        $('#bicicletaDisponible').val(disponibilidad);

        var datos = $('#formularioDisponibilidad').serialize();

        if (disponibilidad === "") {
            alert("Por favor, seleccione si la bicicleta está disponible o no.");
            return;
        }


        $.ajax({
            url: urlAlquilar,  // Usa la variable definida en la vista
            type: 'POST',
            data: datos,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.ocultarDisponible();
                    window.mostrarPagarAlquiler();
                };
            },
            error: function (response) {
                console.log('Hubo un error al enviar el formulario');
            }
        });
    });
});

window.ocultarDisponible = function () {
    $('#contenedorDisponibilidad').removeClass('flex').addClass('hidden');
}

window.mostrarPagarAlquiler = function () {
    $('#contenedorPagarAlquiler').removeClass('hidden');
}
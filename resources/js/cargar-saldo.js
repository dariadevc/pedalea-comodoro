import $ from 'jquery';
window.$ = $;

$(document).ready(function () {

    window.mostrarBusqueda = function () {
        $('#overlay').removeClass('invisible');
    }
    window.mostrarCargarSaldo = function () {
        $('#modalConfirmacion').addClass('invisible');
        window.mostrarBusqueda();
    }

    window.ocultarBusqueda = function () {
        $('#overlay').addClass('invisible');
    }


    $(document).on('click', function (event) {
        if ($(event.target).closest('#tarjeta_cargar_saldo').length === 0 && $(event.target).closest('#overlay').length > 0) {
            ocultarBusqueda();
        }
    });

    $('#cerrar_tarjeta').on('click', function () {
        ocultarBusqueda();
    });

    $('#btn_mostrar_modal').on('click', function () {
        mostrarBusqueda();
    });

    $(document).on('submit', '#paymentForm', function (event) {
        event.preventDefault();

        $('#errorCarga').addClass('invisible');
        $('#paymentForm .text-red-500').addClass('hidden').text('');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.ocultarBusqueda();
                    $('#idSaldo').empty();
                    $('#idSaldo').text('Saldo actual disponible: $' + response.saldo + '.00');
                    $('#contenedorSaldoCargado h2').empty();
                    $('#contenedorSaldoCargado h2').text(response.mensaje);
                    $('#contenedorSaldoCargado').removeClass('invisible');
                } else {
                    $('#errorCarga').empty();
                    $('#errorCarga').text(response.mensaje);
                    $('#errorCarga').removeClass('invisible');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        // Seleccionar el campo y buscar un mensaje de error asociado
                        let errorElement = $(`#${key}`).next('.text-red-500');
                        if (errorElement.length) {
                            // Mostrar el mensaje si el elemento ya existe
                            errorElement.removeClass('hidden').text(errors[key][0]);
                        } else {
                            // Crear el mensaje de error si no existe
                            $(`#${key}`).after(`<div class="text-red-500 text-sm mt-1">${errors[key][0]}</div>`);
                        }
                    }
                } else {
                    alert('Ocurrió un error inesperado. Por favor, intenta de nuevo.');
                }
            }
        });
    });
});

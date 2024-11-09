import $ from 'jquery';
window.$ = $;

function handleSearchButton() {
    const dniInput = $('#dni');
    const buscarButton = $('#buscar_usuario');
    const dniError = $('#dni_error'); // Contenedor para el mensaje de error

    // Deshabilitar el botón al inicio
    buscarButton.prop('disabled', true);

    // Añadir un listener para cuando el campo DNI cambie
    dniInput.on('input', function () {
        const dni = dniInput.val().trim();

        // Verificar si el DNI tiene exactamente 8 dígitos
        if (dni.length === 8 && !isNaN(dni) && dni >= 20000000 && dni <= 99999999) {
            buscarButton.prop('disabled', false); // Habilitar el botón
            dniError.hide(); // Ocultar el mensaje de error si el DNI es válido
        } else {
            buscarButton.prop('disabled', true); // Deshabilitar el botón
            dniError.show(); // Mostrar el mensaje de error
        }
    });

    $('#buscar_usuario').on('click', function () {
        const dni = $('#dni').val(); // Asume que el input tiene id="dniInput"

        $.ajax({
            url: '/reserva-actual/buscar-usuario', // Cambia la ruta según sea necesario
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Incluye el token CSRF
            },
            data: {
                dni: dni
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Inserta la vista de éxito en el contenedor "tarjeta_reasignar"
                    $('#tarjeta_reasignar').html(response.successView);
                    $('#aceptar_reasignacion').on('click', function () {
                        // Recarga la página después de hacer clic en el botón 'aceptar'
                        location.reload(); // Esto recarga la página
                    });
                } else {
                    // Si hubo un error, muestra la vista de error en "tarjeta_reasignar"
                    $('#tarjeta_reasignar').html(response.errorView);

                    $('#cerrar_tarjeta_reasignar').on('click', function () {
                        $('#tarjeta_reasignar').empty(); // Limpia el contenido actual
                        $('#dni').val(''); // Limpia el campo de DNI, si es necesario

                        // Carga nuevamente el formulario de búsqueda
                        $.get('/reserva-actual/formulario-busqueda', function (view) {
                            $('#tarjeta_reasignar').html(view);
                            handleSearchButton();
                        });

                        // Desactiva la visualización del modal con Alpine
                        document.querySelector('#tarjeta_reasignar').dispatchEvent(new CustomEvent('cerrar-tarjeta', {
                            bubbles: true
                        }));
                    });
                }
            },
            error: function(xhr) {
                console.error('Error en la solicitud AJAX:', xhr.responseText);
                $('#tarjeta_reasignar').html('<p>Hubo un problema con la reasignación.</p>');
            }
        });
    });
}

handleSearchButton();
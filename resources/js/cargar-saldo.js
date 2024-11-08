import $ from 'jquery';
window.$=$;

window.irCargarSaldo = function () {
    $.ajax({
        url: urlGuardarCargarSaldo,
        type: 'POST',
        data: {
            url_actual: window.location.href,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                window.location.href = response.redirigir;
            } else {
            }
        },
        error: function (xhr, status, error) {
            console.log('Status:', status); // Ver el estado (como 500, 404, etc.)
            console.log('Error:', error); // Mensaje general de error
            console.log('Response:', xhr.responseText); // Ver el cuerpo completo de la respuesta
        }

    });
}
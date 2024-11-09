import $ from 'jquery';
window.$ = $;


$(document).ready(function () {
    $('#btnSi').click(function () {
        $('#mensajeDanios').hide();
        $('#btnNo').hide();
        $(this).hide();

        // Simulación de datos obtenidos del backend
        let datos = {}; // Aquí debes cargar los datos correspondientes

        let elementosArray = Object.values(datos);
        $('#divFormDanios').append(`
            <h2 style="font-size: 24px; margin-bottom: 15px; color: #333;" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Seleccione un elemento</h2>
            <form id="miFormulario" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">
                ${elementosArray.map(info => `
                    <div style="margin-bottom: 10px;">
                        <label style="font-size: 18px; color: #555;">
                            <input type="checkbox" name="elementos[]" value="${info.tipo_danio}" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2"> ${info.descripcion}
                        </label>
                    </div>
                `).join('')}
                <button id="formDanios" class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul" type="button" onclick="continuarACalificarEstaciones()">Seleccionar daños</button>
            </form>
        `);
    });

    $('#btnNo').click(function () {
        mostrarCalificacionEstaciones();
    });

    function mostrarCalificacionEstaciones() {
        $('#divDanios').hide();
        $('#formContainer').load('/partials/formulario-calificacion');
    }

    function continuarACalificarEstaciones() {
        $('#divFormDanios').hide();
        // Obtener elementos seleccionados y enviarlos mediante AJAX
        const seleccionados = $('input[name="elementos[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        guardarDaniosSession('url_guardar_danios', 'POST', {
            danios: seleccionados,
            _token: csrfToken // Asegúrate de tener definido csrfToken en tu entorno
        });

        mostrarCalificacionEstaciones();
    }

    function guardarDaniosSession(url, metodo, datos) {
        $.ajax({
            url: url,
            method: metodo,
            data: datos,
            success: function (response) {
                console.log('Mensaje luego de guardar:', response.message);
            },
            error: function (xhr) {
                console.error('Error al guardar daños.');
            }
        });
    }
});

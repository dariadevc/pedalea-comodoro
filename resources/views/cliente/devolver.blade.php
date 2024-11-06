@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Devolver')

@section('nombre_seccion', 'Devolver')

@section('contenido')

    {{-- CONSULTA DAÑOS --}}
    {{-- TODO: Dependiendo de qué opción se elija debería mostrar una checklist de daños o mandarte directamente a calificar. --}}
    <div id="divDanios" class="flex flex-col gap-4">
        <div class="">
            <p id= "mensajeDanios"class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">¿La bicicleta recibió daños?
            </p>
        </div>
        <div class="flex gap-6 self-center">
            <button id="btnSi" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">Si</button>
            <button id="btnNo" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">No</button>
        </div>
    </div>
    
    <div id="divFormDanios">

    </div>
    <div id="formContainer">
        
    </div>

    {{-- DEVOLVER BICICLETA --}}
    {{-- TODO: Al apretar el botón de devolver debería saltar un cartel que tenga un mensaje informando que la devolución se realizó con éxito, el puntaje que obtuvo y un botón que te manda al inicio --}}
    <div class="flex flex-col gap-4">
        <div class="">
            <p id="mensajeDevolucion" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Ya podes devolver tu bicicleta!</p>
        </div>
        <div class="flex gap-6 self-center">
            <button hidden onclick="devolver()" id="botonDevolver" class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">Devolver
                Bicicleta</button>
        </div>
    </div>
    <p id="pid"></p>
<!-- Contenedor donde se generará la lista -->
<div id="detallesSesion" style="display: none;"></div>
@endsection

@section('scripts')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@php
    $detalles = session()->get('detalles', []);
@endphp
<script>

function mostrarDetalles() {
    document.getElementById("pid").innerText = "Aquí van los detalles: fecha y hora de devolución prometida, fecha y hora de devolución real, puntaje obtenido, puntaje actualizado, daños ocasionados a la bicicleta.";
    
    // Convierte los datos de PHP a JSON para JavaScript
 //       const detalles = @json($detalles);

 //       let detallesHTML = "<h3>Datos de la Sesión:</h3><ul>";
 //       for (let clave in detalles) {
  //          detallesHTML += `<li><strong>${clave}:</strong> ${Array.isArray(detalles[clave]) ? JSON.stringify(detalles[clave]) : detalles[clave]}</li>`;
  //      }
  //      detallesHTML += "</ul>";

    //    document.getElementById("detallesSesion").innerHTML = detallesHTML;
    //    document.getElementById("detallesSesion").style.display = 'block';
    }

function devolver(){
    mostrarDetalles();
    $('#mensajeDevolucion').hide();
    $('#botonDevolver').hide();
    $('#divFormDanios')

             evaluarPuntaje(
                "{{ route('evaluar.puntaje') }}",
                        "POST",
               {
               evaluarCliente: 1,
               _token: "{{ csrf_token() }}"
               }
               );
}

//Se activa al presionar el boton devolver Bicicleta. Es lo último que se presiona.
function evaluarPuntaje(url, metodo, datos) {
    $.ajax({
        url: url,
        method: metodo,
        data: datos,
        success: function(response) {
            $('#valorSeleccionado').text(response.mensaje);
            document.getElementById('divFormDanios').innerHTML = '';
            console.log(response.message);
        },
        error: function(xhr) {
            console.log("error");
            let errors = xhr.responseJSON.errors;
            let mensaje = errors ? Object.values(errors).join('. ') : "Ocurrió un error al guardar la calificación.";
            $('#valorSeleccionado').text(mensaje);
        }
    });
}

function guardarDaniosSession(url, metodo, datos) {
    $.ajax({
        url: url,
        method: metodo,
        data: datos,
        success: function(response) {

            console.log("mensaje luego de guardar en la session, los danios seleccionados:"+  response.message);
        },
        error: function(xhr) {
            console.log("error");
            let errors = xhr.responseJSON.errors;
            let mensaje = errors ? Object.values(errors).join('. ') : "Ocurrió un error al guardar la calificación.";
            $('#valorSeleccionado').text(mensaje);
        }
    });
}

    function mostrarCalificacionEstaciones() {
        document.getElementById('divDanios').style.display = 'none';

$('#formContainer').append(`
<form id="formCalif" class="mt-4">

<div class="flex flex-col gap-4">
<div class="">
<p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Califique la Estación de Retiro</p>
</div>
<div id="calificacion"  class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full ">
<div class="rounded-xl bg-gray-50 p-2 py-4 shadow-md flex gap-3">
    {{-- ESTRELLA 1 --}}
    <div class="estrella" data-valor="1">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
    {{-- ESTRELLA 2 --}}
    <div class="estrella" data-valor="2">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
    {{-- ESTRELLA 3 --}}
    <div class="estrella" data-valor="3">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
    {{-- ESTRELLA 4 --}}
    <div class="estrella" data-valor="4">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
    {{-- ESTRELLA 5 --}}
    <div class="estrella" id="okk" data-valor="5">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </div>
</div>
</div>
</div>

<button hidden id="idEnviar" type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Enviar Calificacion</button>

<input type="hidden" name="calificacion" id="inputCalificacion">

</form>

`);
document.querySelectorAll('.estrella').forEach(estrella => {
estrella.addEventListener('click', function() {
const valor = parseInt(this.getAttribute('data-valor'));

// Cambia el color de todas las estrellas según el valor seleccionado
document.querySelectorAll('.estrella').forEach((estrella, index) => {
    if (index < valor) {
        estrella.querySelector('path').style.fill = "#FFD700"; // Color de la estrella seleccionada
    } else {
        estrella.querySelector('path').style.fill = "none"; // Color de la estrella no seleccionada
    }
});
});
});


    }

    function continuarACalificarEstaciones() {

        $('#divFormDanios').hide();
    const seleccionados = [];
    $('input[name="elementos[]"]:checked').each(function() {
        seleccionados.push($(this).val());
    });
    console.log("Elementos seleccionados: ", seleccionados);
    // Aquí puedes agregar más lógica para manejar los elementos seleccionados


    //Lo enviaremos al backend 
        event.preventDefault(); // Prevenir el envío tradicional del formulario

        // Enviar datos con AJAX
        guardarDaniosSession(
        "{{ route('guardar.danios') }}",
        "POST",
        {
        danios: seleccionados,
        _token: "{{ csrf_token() }}"
        }
        );

        mostrarCalificacionEstaciones();

}


    var estacion='retiro';
    var id_estacion_retiro = @json($id_estacion_retiro); // Asignar el valor de Blade a una variable JavaScript

    $(document).ready(function() {
       
        $('#btnSi').click(function() {
            $('#mensajeDanios').hide();
            $('#btnNo').hide();
            $(this).hide(); // Oculta el botón cuando se hace clic
            // Convertir $datos a un array en JavaScript
        let datos = @json($datos); // Esto sigue siendo un objeto
        let elementosArray = Object.values(datos); // Convierte el objeto a un array de valores
        
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

        $('#btnNo').click(function() {
            mostrarCalificacionEstaciones();
 });
    });

</script>

    <script>
        function calificarDevolución() {
            $('#formContainer').append(`
 <form id="formCalif" class="mt-4">

    <div class="flex flex-col gap-4">
        <div class="">
            <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Califique la Estación de devolución</p>
        </div>
        <div id="calificacion"  class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full ">
            <div class="rounded-xl bg-gray-50 p-2 py-4 shadow-md flex gap-3">
                {{-- ESTRELLA 1 --}}
                <div class="estrella" data-valor="1">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                {{-- ESTRELLA 2 --}}
                <div class="estrella" data-valor="2">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                {{-- ESTRELLA 3 --}}
                <div class="estrella" data-valor="3">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                {{-- ESTRELLA 4 --}}
                <div class="estrella" data-valor="4">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                {{-- ESTRELLA 5 --}}
                <div class="estrella" id="okk" data-valor="5">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11.2691 4.41115C11.5006 3.89177 11.6164 3.63208 11.7776 3.55211C11.9176 3.48263 12.082 3.48263 12.222 3.55211C12.3832 3.63208 12.499 3.89177 12.7305 4.41115L14.5745 8.54808C14.643 8.70162 14.6772 8.77839 14.7302 8.83718C14.777 8.8892 14.8343 8.93081 14.8982 8.95929C14.9705 8.99149 15.0541 9.00031 15.2213 9.01795L19.7256 9.49336C20.2911 9.55304 20.5738 9.58288 20.6997 9.71147C20.809 9.82316 20.8598 9.97956 20.837 10.1342C20.8108 10.3122 20.5996 10.5025 20.1772 10.8832L16.8125 13.9154C16.6877 14.0279 16.6252 14.0842 16.5857 14.1527C16.5507 14.2134 16.5288 14.2807 16.5215 14.3503C16.5132 14.429 16.5306 14.5112 16.5655 14.6757L17.5053 19.1064C17.6233 19.6627 17.6823 19.9408 17.5989 20.1002C17.5264 20.2388 17.3934 20.3354 17.2393 20.3615C17.0619 20.3915 16.8156 20.2495 16.323 19.9654L12.3995 17.7024C12.2539 17.6184 12.1811 17.5765 12.1037 17.56C12.0352 17.5455 11.9644 17.5455 11.8959 17.56C11.8185 17.5765 11.7457 17.6184 11.6001 17.7024L7.67662 19.9654C7.18404 20.2495 6.93775 20.3915 6.76034 20.3615C6.60623 20.3354 6.47319 20.2388 6.40075 20.1002C6.31736 19.9408 6.37635 19.6627 6.49434 19.1064L7.4341 14.6757C7.46898 14.5112 7.48642 14.429 7.47814 14.3503C7.47081 14.2807 7.44894 14.2134 7.41394 14.1527C7.37439 14.0842 7.31195 14.0279 7.18708 13.9154L3.82246 10.8832C3.40005 10.5025 3.18884 10.3122 3.16258 10.1342C3.13978 9.97956 3.19059 9.82316 3.29993 9.71147C3.42581 9.58288 3.70856 9.55304 4.27406 9.49336L8.77835 9.01795C8.94553 9.00031 9.02911 8.99149 9.10139 8.95929C9.16534 8.93081 9.2226 8.8892 9.26946 8.83718C9.32241 8.77839 9.35663 8.70162 9.42508 8.54808L11.2691 4.41115Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <button hidden id="idEnviar" type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Enviar Calificacion</button>

    <input type="hidden" name="calificacion" id="inputCalificacion">
    <input type="hidden" name="devolucion" id="estacion">
    </form>

            `)

            document.querySelectorAll('.estrella').forEach(estrella => {
        estrella.addEventListener('click', function() {
            const valor = parseInt(this.getAttribute('data-valor'));

            // Cambia el color de todas las estrellas según el valor seleccionado
            document.querySelectorAll('.estrella').forEach((estrella, index) => {
                if (index < valor) {
                    estrella.querySelector('path').style.fill = "#FFD700"; // Color de la estrella seleccionada
                } else {
                    estrella.querySelector('path').style.fill = "none"; // Color de la estrella no seleccionada
                }
            });
        });
    });

            
        }


       jQuery.noConflict();
        jQuery(document).ready(function($) {
    console.log("jQuery está funcionando!"); // Verificar si jQuery se carga correctamente

    // Cuando se hace clic en una estrella
    $('#formContainer').on('click', '.estrella', function() {
        document.getElementById("idEnviar").style.display = "inline-block";

        // Remover la clase 'seleccionada' de todas las estrellas
        $('#calificacion .estrella').removeClass('seleccionada');

        // Agregar la clase 'seleccionada' solo a la estrella en la que se hizo clic
        $(this).addClass('seleccionada');

        // Obtener el valor de la estrella seleccionada
        var valorSeleccionado = $(this).data('valor');

        // Asignar el valor al campo oculto para el envío del formulario
        $('#inputCalificacion').val(valorSeleccionado);
    });

    // Enviar el formulario con AJAX
    $(document).on('submit', '#formCalif', function(event) {
        event.preventDefault(); // Prevenir el envío tradicional del formulario

        var calificacion = $('#inputCalificacion').val();
        console.log("aqui estoy  "+ calificacion);
        // Enviar datos con AJAX
        if (estacion === 'retiro') {

            $.ajax({
                url: "{{ route('guardar.calif') }}",
                method: "POST",
                data: {
                    calificacion: calificacion,
                    id_estacion: id_estacion_retiro,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#valorSeleccionado').text(response.mensaje);
                    $('#formCalif')[0].reset(); // Limpiar el formulario
                    $('#calificacion .estrella').removeClass('seleccionada'); // Limpiar selección
                    document.getElementById('formContainer').innerHTML = '';
                    estacion ='devolucion';
                    calificarDevolución();
                },
                error: function(xhr) {
                    console.log("error");
                    let errors = xhr.responseJSON.errors;
                    let mensaje = errors ? Object.values(errors).join('. ') : "Ocurrió un error al guardar la calificación.";
                    $('#valorSeleccionado').text(mensaje);
                }
            });
        } else {

            var id_estacion_devolucion = @json($id_estacion_devolucion); // Asignar el valor de Blade a una variable JavaScript

            // Enviar datos con AJAX
            $.ajax({
                url: "{{ route('guardar.calif') }}",
                method: "POST",
                data: {
                    calificacion: calificacion,
                    id_estacion: id_estacion_devolucion,
                    _token: "{{ csrf_token() }}"
                },
                
                success: function(response) {
                    $('#valorSeleccionado').text(response.mensaje);
                    $('#formCalif')[0].reset(); // Limpiar el formulario
                    $('#calificacion .estrella').removeClass('seleccionada'); // Limpiar selección
                    document.getElementById('formContainer').innerHTML = ''; // Limpiar el contenedor del formulario
                    document.getElementById("botonDevolver").style.display = "inline-block";


                },
                error: function(xhr) {
                    console.log("error");
                    let errors = xhr.responseJSON.errors;
                    let mensaje = errors ? Object.values(errors).join('. ') : "Ocurrió un error al guardar la calificación.";
                    $('#valorSeleccionado').text(mensaje);
                }
            });
        }
    });
});

</script>
@endsection


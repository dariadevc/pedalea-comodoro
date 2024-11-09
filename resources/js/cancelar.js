import $ from 'jquery';
window.$ = $;

//* Lógica para poder esconder y mostrar el modal al momento de apretar el botón cancelar.
window.toogleModal = function() {
    $('#modalConfirmacion').toggleClass('invisible');
}

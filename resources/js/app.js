import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery';

window.Alpine = Alpine;
Alpine.start();

window.$ = window.jQuery = $;

$(document).ready(function() {
    console.log('jQuery is working!');
});
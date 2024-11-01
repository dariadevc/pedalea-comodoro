<div id="contenedor-pasos">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</div>

@vite('resources/js/reservar.js')
<script>
    var urlPasos = "{{ route('reservar.pasos') }}"
</script>

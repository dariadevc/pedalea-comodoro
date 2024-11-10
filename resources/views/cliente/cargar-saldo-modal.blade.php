<div id="overlay" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
    <div id="tarjeta_cargar_saldo"
        class="flex flex-col p-8 gap-2 bg-gray-50 border-blue-500 border-4 rounded-3xl shadow-lg w-3/4 max-w-md">
        <button id="cerrar_tarjeta" class="place-self-end">
            <svg xmlns="http://www.w3.org/2000/svg" height="25px" width="25px" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" class="text-gray-800">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        @include('cliente.partials.pasarela-de-pago')
    </div>
</div>

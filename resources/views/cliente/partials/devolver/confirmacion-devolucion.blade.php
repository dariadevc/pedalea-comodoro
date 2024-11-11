{{-- resources/views/cliente/partials/devolver/confirmacion-devolucion.blade.php --}}
<div class="flex flex-col items-center justify-center mt-8">
    <div class="bg-white p-6 shadow-md rounded-xl border-l-4 border-l-pc-azul text-gray-800 text-center w-full max-w-xl">
        <h2 class="text-xl font-semibold mb-4 text-pc-azul">¡Calificación Completada!</h2>
        <p class="text-md mb-4">Gracias por calificar las estaciones. Tu bicicleta ya puede ser devuelta.</p>
        <form id="formularioConfirmarDevolucion" action="{{ route('devolver.confirmar') }}" method="POST">
            @csrf
            <x-btn-rojo-blanco type="submit">Confirmar Devolución</x-btn-rojo-blanco>
        </form>
    </div>
</div>

<section id="cargar-saldo" class="relative flex flex-col items-center justify-center px-10 my-12 h-auto">
    <div
        class="container bg-gray-100 flex flex-col rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center gap-3 px-8 md:px-16">
        <h2 class="font-bold text-3xl text-pc-azul border-b border-pc-azul py-4">Cargar Saldo</h2>
        <p class="text-sm mt-4 text-pc-texto-p">Ingresa el monto que deseas cargar a tu cuenta</p>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-full my-2"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div id="errorCarga"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-full my-2 hidden"
            role="alert">
            <span class="block sm:inline"></span>
        </div>

        {{-- FORMULARIO --}}
        <form id="cargarSaldoForm" class="flex flex-col gap-8 mt-2 items-center w-full">
            @csrf
            {{-- INFORMACIÓN DE PAGO --}}
            <fieldset class="grid grid-cols-1 gap-6 border-t- w-full">
                <div class="flex flex-col gap-2">
                    <label for="monto">Monto a cargar</label>
                    <div class="flex overflow-hidden">
                        <span class="flex items-center px-3 p-2 rounded-l-xl bg-gray-200 text-black">$</span>
                        <input type="number" name="monto" id="monto" placeholder="1000" required autofocus
                            class="flex-1 border rounded-r-xl focus:ring-0 p-2 border-gray-300 w-full shadow-sm" />
                    </div>
                </div>
            </fieldset>

            <x-btn-azul-blanco type="submit">{{ 'Proceder al Pago' }}</x-btn-azul-blanco>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cargarSaldoForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            $('#errorCarga').addClass('hidden').find('span').text('');
            $.ajax({
                url: '{{ route('pago.procesar') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.open(response.redirect, '_blank');
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Hubo un error al procesar el pago.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    $('#errorCarga').removeClass('hidden').find('span').text(
                        errorMessage);
                }
            });
        });
    });
</script>

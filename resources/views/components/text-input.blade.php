{{-- Input utilizado en el login y el registro, la idea es usarlo en el resto de formularios --}}

{{-- Indica que el valor predeterminado el disabled siempre va a ser false, para cambiarlo solo hay que agregar disabled en la vista que se utilice. --}}
@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 p-2 rounded-xl border w-full shadow-sm']) }}>

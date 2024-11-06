@props(['ruta'])

<li>
    <a href="{{ route($ruta) }}"
        {{ $attributes->merge(['class' => 'flex items-center p-2 text-pc-texto-h rounded-xl hover:bg-white hover:shadow-md my-1 ' . (Request::routeIs($ruta) ? 'bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current' : '')]) }}>
        <span class="flex-1 ms-3">{{ $slot }}</span>
    </a>
</li>

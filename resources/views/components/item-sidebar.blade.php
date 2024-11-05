<li>
    <a
        {{ $attributes->merge(['class' => 'flex items-center p-2 text-pc-texto-h rounded-xl hover:bg-white hover:shadow-md my-1']) }}>
        <span class="flex-1 ms-3">{{ $slot }}</span>
    </a>
</li>

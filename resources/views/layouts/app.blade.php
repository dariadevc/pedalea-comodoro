<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedalea Comodoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/layout-app.js'])

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen white ">
            {{-- NO OLVIDARSE DE DESCOMENTAR LA LINEA DE ABAJO --}}
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{-- {{ $slot }} --}}
                @yield('content')
            </main>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <main id="main" class="flex flex-col mt-14 p-8 gap-8  lg:ml-64 overflow-y-auto">
        @yield('contenido')
    </main>

    @yield('scripts')
</body>

</html>

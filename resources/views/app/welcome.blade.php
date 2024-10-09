<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canal de Denuncias</title>
    <link rel="shortcut icon" href="https://home.hcmfront.com/hubfs/favicon@3x.png">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
        }
    </style>
</head>
{{debugbar()->info(tenant())}}
<body class="bg-white text-gray-900 antialiased">

<nav class="bg-white shadow-md p-6 flex justify-between items-center">
    <div>
        <img src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt="Logo" class="h-12">
    </div>
    <div>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><i class="fa-solid fa-bars mr-2"></i>Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><i class="fa-solid fa-right-to-bracket mr-2"></i>Entrar</a>

                    {{--@if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Register</a>
                    @endif--}}
                @endauth
            </div>
        @endif
    </div>
</nav>
<div class="text-4xl">
    <p class="text-gray-700 mt-8 text-center font-bold">Canal de Denuncias</p>
</div>
<div class="container mx-auto p-6 mt-8 flex flex-col justify-center items-center md:flex-row">
    <!-- Left Column -->
    <div class="md:w-1/2 md:pr-8">
        @if($dynamicText)
            <p class="text-gray-700">
                <b>En {{ tenant('domain_name') }} tu voz cuenta: Denuncia segura y confidencial</b><br><br>
                {{ $dynamicText->texto }}
            </p>
        @else 
            <p class="text-gray-700">
                
                ¿Qué es la Ley Karin?<br>
                La Ley 21.643 tiene por objeto prevenir, investigar y sancionar el acoso laboral, el acoso
                sexual, así como la violencia en el trabajo, garantizando los derechos de las víctimas y
                facilitando el acceso a la justicia.<br>
                Presenta tu denuncia de forma fácil y segura. Nuestro portal te brinda un espacio
                confidencial para que puedas expresar lo ocurrido.<br>
                <b>¿Cómo presentar una denuncia?</b><br>
                1) Completa un sencillo formulario donde podrás describir detalladamente lo sucedido.<br>
                2) Selecciona la categoría que mejor se ajuste a tu situación para agilizar el proceso.<br>
                3) Puedes adjuntar documentos, fotografías u otros archivos que puedan respaldar tu
                denuncia (opcional).<br>
                4) Al finalizar, recibirás un código único que te permitirá hacer seguimiento a tu denuncia
                en cualquier momento. <b>¡Guárdalo en un lugar seguro!</b><br>
                Tu denuncia es importante. Cada caso es revisado con la mayor confidencialidad y se
                toman las medidas necesarias para proteger tu identidad.<br>
                <b>¡No dudes en denunciar! Tu voz es fundamental para erradicar el acoso y la
                    violencia</b>
            </p>
        @endif
    </div>

    <!-- Right Column -->
    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0">
        <p class="text-gray-700 text-4xl">Ingresa nueva denuncia</p>
        <button type="button" onclick="window.location.href='{{ route('denuncia.create', ['tenant_id' => tenant('id')]) }}'" class="mt-3 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            Continuar
        </button>

        <p class="text-gray-700 mt-8 text-4xl">Revisa el estado de tu denuncia</p>
        <p class="text-gray-700">Ingresa el número y clave proporcionada.</p>

        <!-- Form to handle submission -->
        <form action="{{ route('denuncia.status') }}" method="GET">
            <input type="text" name="numero" class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Numero de denuncia">
            <input type="text" name="clave" class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Clave">

            <!-- Submit button inside the form -->
            <button type="submit" class="mt-3 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Consultar</button>
        </form>
    </div>

</div>
</body>
</html>

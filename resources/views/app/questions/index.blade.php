<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Denuncia</title>
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
<nav class="bg-white shadow-md p-6 flex justify-between items-center">
    <div>
        <img src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt="Logo" class="h-12">
    </div>
</nav>
<div class="text-4xl">
    <p class="text-gray-700 mt-8 text-center font-bold">Canal de Denuncias</p>
</div>
<section class="dark:text-gray-800">
    <div class="container max-w-5xl px-4 py-12 mx-auto">
        <div class="grid gap-4 mx-4 sm:grid-cols-12">
            <div class="col-span-12 sm:col-span-3">
                <div class="text-center sm:text-left mb-14 before:block before:w-24 before:h-3 before:mb-5 before:rounded-md before:mx-auto sm:before:mx-0 before:dark:bg-sky-600">
                    <h5 class="text-1xl font-semibold">Denunciante:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">Andrea Bogado</span>
                    <h5 class="text-1xl font-semibold">Tipo de denuncia:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">Acoso</span>
                    <h5 class="text-1xl font-semibold">Denunciado:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">Jose Castro - Contralor</span>
                    <h5 class="text-1xl font-semibold">Fecha denuncia:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">30/08/2024</span>

                    <h5 class="text-1xl font-semibold mt-3">Estado Actual:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">Recibida</span>
                    <h5 class="text-1xl font-semibold">Responsable:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">Maritza Cerda</span>
                    <h5 class="text-1xl font-semibold">Denunciado:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">25 dias</span>
                </div>
            </div>
            <div class="relative col-span-12 px-4 space-y-6 sm:col-span-9">
                <div class="col-span-12 space-y-12 relative px-4 sm:col-span-8 sm:space-y-8 sm:before:absolute sm:before:top-2 sm:before:bottom-0 sm:before:w-0.5 sm:before:-left-3 before:dark:bg-gray-300">
                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                        <h3 class="text-xl font-semibold tracking-wide">Denuncia Recibida</h3>
                        <time class="text-xs tracking-wide uppercase dark:text-gray-600">21/08/2024 16:25:00</time>
                    </div>
                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                        <h3 class="text-xl font-semibold tracking-wide">Información</h3>
                        <time class="text-xs tracking-wide uppercase dark:text-gray-600">21/08/2024 16:25:00</time>
                    </div>
                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                        <h3 class="text-xl font-semibold tracking-wide">Información</h3>
                        <time class="text-xs tracking-wide uppercase dark:text-gray-600">21/08/2024 16:25:00</time>
                    </div>
                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                        <h3 class="text-xl font-semibold tracking-wide">Resuelta</h3>
                        <time class="text-xs tracking-wide uppercase dark:text-gray-600">21/08/2024 16:25:00</time>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-6">
            <a href="{{ url('/') }}" class="inline-block bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-semibold py-3 px-6 rounded-lg">Volver al inicio</a>
        </div>
    </div>
</section>
{{--<div class="container mx-auto p-6 mt-8 flex flex-col md:flex-row">
    <!-- Left Column -->
    <div class="md:w-1/2 md:pr-8">
        <p class="text-gray-700">
        <p class="text-lg"><b>Denunciante:</b> Andrea Bogado.</p>
        <p class="text-lg"><b>Tipo de denuncia:</b> Acoso.</p>
        <p class="text-lg"><b>Denunciado:</b> Jose Castro - Contralor.</p>
        <p class="text-lg"><b>Fecha denuncia:</b> 30/08/2024</p>
        </p>
        <p class="text-gray-700">
        <p class="text-lg"><b>Estado Actual: Recibida</b></p>
        <p class="text-lg"><b>Responsable: Maritza Cerda</b></p>
        <p class="text-lg"><b>Denunciado: 25 dias.</b></p>
        </p>
    </div>

    <!-- Right Column -->
    <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0">
        <div class="flex items-center justify-center py-10">
            <div class="max-w-screen-sm lg:max-w-screen-md xl:max-w-screen-lg px-20 mx-auto">
                <ol class="relative border-l-4 border-indigo-600 pl-8 leading-loose">
                    <li class="mb-10 w-96">
                        <!-- Cambiamos las clases para centrar el ícono y aumentar su tamaño -->
                        <div class="absolute -left-7 transform -translate-x-1/2 -translate-y-1/2 text-indigo-600 text-4xl">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="ml-8"> <!-- Ajustamos el margen izquierdo para alinear el contenido -->
                            <p class="font-bold text-lg mb-1"><i class="fa-solid fa-circle-info mr-2"></i>Denuncia Recibida</p>
                            <p>21/08/2024 16:25:00</p>
                        </div>
                    </li>
                    <li class="mb-10 w-96">
                        <div class="absolute -left-7 transform -translate-x-1/2 -translate-y-1/2 text-indigo-600 text-4xl">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="ml-8">
                            <p class="font-bold text-lg mb-1"><i class="fa-solid fa-circle-info mr-2"></i>Informacion</p>
                            <p>21/08/2024 16:25:00</p>
                        </div>
                    </li>
                    <li class="mb-10 w-96">
                        <div class="absolute -left-7 transform -translate-x-1/2 -translate-y-1/2 text-indigo-600 text-4xl">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="ml-8">
                            <p class="font-bold text-lg mb-1"><i class="fa-solid fa-circle-info mr-2"></i>Información</p>
                            <p>21/08/2024 16:25:00</p>
                        </div>
                    </li>
                    <li class="mb-10 w-96">
                        <div class="absolute -left-7 transform -translate-x-1/2 -translate-y-1/2 text-indigo-600 text-4xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="ml-8">
                            <p class="font-bold text-lg mb-1"><i class="fa-solid fa-circle-check mr-2"></i>Resuelta</p>
                            <p>21/08/2024 16:25:00</p>
                        </div>
                    </li>
                    <li class="mb-10 w-96">
                        <div class="absolute -left-7 transform -translate-x-1/2 -translate-y-1/2 text-indigo-600 text-4xl">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="ml-8">
                            <p class="font-bold text-lg mb-1"><i class="fa-solid fa-circle-info mr-2"></i>Denuncia Recibida</p>
                            <p>21/08/2024 16:25:00</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>--}}
</body>
</html>

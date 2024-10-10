<!-- resources/views/denuncia/completado.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncia Completada</title>
    <link rel="shortcut icon" href="https://home.hcmfront.com/hubfs/favicon@3x.png">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
@php
    // Configura la URL de la API y los encabezados
    $apiKey = tenant()->api_key;
    $url = "https://api.hcmfront.com/v1/company/";
    $headers = [
        "Authorization: Token $apiKey",
        "Content-Type: application/json"
    ];

    // Realiza la solicitud a la API
    $response = file_get_contents($url, false, stream_context_create([
        'http' => [
            'header'  => implode("\r\n", $headers),
            'method'  => 'GET',
        ]
    ]));

    // Decodifica la respuesta JSON
    $data = json_decode($response, true);

    // Obtén la URL de la imagen
    $imagenUrl = $data[0]['imagen'] ?? '';
@endphp
<nav class="bg-white shadow-md p-6 flex justify-between items-center">
    @if (!empty($imagenUrl))
        <div>
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><img src="{{ $imagenUrl }}" alt="Logo" class="h-12"></a>
        </div>
    @else
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><img src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt="Imagen de la empresa" class="max-w-full h-auto mx-auto block"></a>
        </div>
    @endif
</nav>

<div class="text-4xl">
    <p class="text-gray-700 mt-8 text-center font-bold">Canal de Denuncias</p>
</div>

<div class="container mx-auto p-6 mt-8 text-start">
    <div class="flex justify-between items-start mb-6">
        <!-- Columna izquierda -->
        <h1 class="text-3xl font-bold">Ha completado su denuncia</h1>

        <!-- Columna derecha: Mostrar el Identificador y la Clave que se han almacenado -->
        <div class="text-end">
            <p class="text-lg text-start"><strong>Identificador:</strong> {{ $identificador }}</p>
            <p class="text-lg text-start"><strong>Clave:</strong> {{ $clave }}</p>
        </div>
    </div>

    @if ($dymanicText)
        <p class="text-lg">{{ $dymanicText->texto }}</p>
    @else
        <p class="text-lg">Nuestro protocolo de seguimiento de denuncias de Ley Karin</p>
        <p class="text-lg">Al recibir una denuncia, garantizamos la confidencialidad e iniciaremos una investigación exhaustiva. Un equipo designado recopilará evidencia, entrevistará a las partes involucradas y elaborará un informe detallado. Se adoptarán medidas cautelares si son necesarias para protegerte o a la victima en caso de que no seas tú. Una vez concluida la investigación, se emitirá una resolución y se aplicarán las sanciones correspondientes. Se realizará un seguimiento continuo para asegurar la efectividad de las medidas adoptadas y prevenir nuevas ocurrencias. Este proceso se llevará a cabo de manera imparcial, eficiente y respetuosa con tu derechos, promoviendo ambientes laborales seguros y libres de violencia.</p>
    @endif

    <p class="text-lg font-bold mt-3">Principios que nos rigen:</p>
    <p class="text-lg">Confidencialidad: Protección de la identidad de la víctima.</p>
    <p class="text-lg">Investigación exhaustiva: Recopilación de evidencia y entrevistas.</p>
    <p class="text-lg">Medidas cautelares: Protección inmediata de la víctima.</p>
    <p class="text-lg">Resolución imparcial: Sanciones a los responsables.</p>
    <p class="text-lg">Seguimiento continuo: Prevención de nuevas ocurrencias.</p>

    <!-- Alineación del botón a la derecha -->
    <div class="text-right mt-6">
        <a href="{{ url('/') }}" class="inline-block bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-semibold py-3 px-6 rounded-lg">Volver al inicio</a>
    </div>
</div>

</body>
</html>

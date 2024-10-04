<style>
    .page_404 {
        padding: 40px 0;
        background: #fff;
        font-family: "Arvo", serif;
    }

    .page_404 img {
        width: 100%;
    }

    .four_zero_four_bg {
        background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
        height: 400px;
        background-position: center;
    }

    .four_zero_four_bg h1 {
        font-size: 80px;
    }

    .four_zero_four_bg h3 {
        font-size: 80px;
    }

    .link_404 {
        color: #fff !important;
        padding: 10px 20px;
        background: #39ac31;
        margin: 20px 0;
        display: inline-block;
    }
    .contant_box_404 {
        margin-top: -50px;
    }
</style>
<section class="page_404 py-10 bg-white">
    <div class="container mx-auto">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <div class="four_zero_four_bg bg-center bg-no-repeat bg-cover h-96"
                         style="background-image: url('https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif');">
                        <h1 class="text-8xl font-bold text-white">404</h1>
                    </div>

                    <div class="contant_box_404 mt-10">
                        <h3 class="text-4xl font-semibold text-gray-800">
                            Parece que estás perdido
                        </h3>
                        <p class="text-lg text-gray-600 mt-4">¡La página que estás buscando no está disponible!</p>

                        <a href="/" class="link_404 mt-6 inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Volver a la página principal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No existe esta dirección</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Si usas TailwindCSS -->
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
<div class="text-center">
    <h1 class="text-4xl font-bold text-gray-800">No existe esta dirección</h1>
    <p class="mt-4 text-lg text-gray-600">Lo sentimos, pero el dominio al que intentas acceder no está registrado.</p>
    <a href="{{ env('APP_URL_ROOT') }}" class="mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded">Volver a la página principal</a>
</div>
</body>
</html>--}}

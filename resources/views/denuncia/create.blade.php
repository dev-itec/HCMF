<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Denuncia</title>
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
    <div>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><i class="fa-solid fa-right-to-bracket"></i>Log in</a>

                    {{--@if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Register</a>
                    @endif--}}
                @endauth
            </div>
        @endif
    </div>
</nav>
<div class="container mx-auto p-6 mt-8">
    <h1 class="text-3xl font-bold text-center mb-8">Formulario de Denuncia</h1>

    {{--<form action="{{ route('denuncia.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">--}}
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- ¿Desea que esta denuncia sea anónima? -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Desea que esta denuncia sea anónima?</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="anonima" value="si" class="form-radio">
                    <span class="ml-2">Sí</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="anonima" value="no" class="form-radio">
                    <span class="ml-2">No</span>
                </label>
            </div>
        </div>

        <!-- Nombre completo -->
        <div>
            <label class="block text-gray-700 font-semibold">Nombre completo</label>
            <input type="text" name="nombre_completo" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Cargo -->
        <div>
            <label class="block text-gray-700 font-semibold">Cargo</label>
            <input type="text" name="cargo" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Correo electrónico -->
        <div>
            <label class="block text-gray-700 font-semibold">Correo electrónico</label>
            <input type="email" name="correo_electronico" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Relación con la empresa -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Cuál es su relación con [Nombre empresa]?</label>
            <select name="relacion" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <option value="Trabajador">Trabajador(a)</option>
                <option value="Contratista">Trabajador(a) de empresa contratista</option>
                <option value="Proveedor">Proveedor</option>
                <option value="Cliente">Cliente</option>
                <option value="Accionista">Accionista</option>
                <option value="Comunidad">Comunidad</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <!-- Tipo de Denuncia -->
        <div>
            <label class="block text-gray-700 font-semibold">Tipo de Denuncia (Marque todas las que apliquen)</label>
            <div class="mt-2 space-y-2">
                <label class="block">
                    <input type="checkbox" name="tipo_denuncia[]" value="Tipo 1" class="form-checkbox">
                    <span class="ml-2">Tipo 1</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="tipo_denuncia[]" value="Tipo 2" class="form-checkbox">
                    <span class="ml-2">Tipo 2</span>
                </label>
                <!-- Agregar más opciones según sea necesario -->
            </div>
        </div>

        <!-- Detalles del incidente -->
        <div>
            <label class="block text-gray-700 font-semibold">Detalles del incidente</label>
            <textarea name="detalles_incidente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- Fecha exacta -->
        <div>
            <label class="block text-gray-700 font-semibold">Fecha exacta</label>
            <input type="date" name="fecha_exacta" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Fecha aproximada -->
        <div>
            <label class="block text-gray-700 font-semibold">Fecha aproximada</label>
            <input type="date" name="fecha_aproximada" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Hora del incidente -->
        <div>
            <label class="block text-gray-700 font-semibold">Hora del incidente (si aplica)</label>
            <input type="time" name="hora_incidente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Lugar del incidente -->
        <div>
            <label class="block text-gray-700 font-semibold">Lugar del incidente</label>
            <textarea name="lugar_incidente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- Descripción del caso -->
        <div>
            <label class="block text-gray-700 font-semibold">Describa el caso o denuncia</label>
            <textarea name="descripcion_caso" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- Personas involucradas -->
        <div>
            <label class="block text-gray-700 font-semibold">Mencione a la(s) persona(s) involucrada(s)</label>
            <textarea name="personas_involucradas" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- Testigos -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Hay testigos? Indique</label>
            <textarea name="testigos" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- ¿Cómo se dio cuenta de la situación? -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Cómo se dió cuenta de esta situación?</label>
            <select name="como_se_entero" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <option value="Lo viví">Lo viví</option>
                <option value="Lo ví/escuche">Lo ví/escuché</option>
                <option value="Me contó un trabajador de la empresa">Me contó un trabajador de la empresa</option>
                <option value="Me contó un externo">Me contó un externo</option>
                <option value="Otro">Otro</option>
            </select>
            <input type="text" name="como_se_entero_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Impacto en la empresa -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Qué impacto tiene en la empresa y en usted esta denuncia?</label>
            <div class="mt-2 space-y-2">
                <label class="block">
                    <input type="checkbox" name="impacto_empresa[]" value="Financiero" class="form-checkbox">
                    <span class="ml-2">Financiero</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_empresa[]" value="Reputacional" class="form-checkbox">
                    <span class="ml-2">Reputacional</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_empresa[]" value="Seguridad" class="form-checkbox">
                    <span class="ml-2">Seguridad</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_empresa[]" value="Otro" class="form-checkbox">
                    <span class="ml-2">Otro</span>
                </label>
            </div>
            <input type="text" name="impacto_empresa_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Impacto personal -->
        <div>
            <label class="block text-gray-700 font-semibold">Impacto Personal</label>
            <div class="mt-2 space-y-2">
                <label class="block">
                    <input type="checkbox" name="impacto_personal[]" value="Emocional" class="form-checkbox">
                    <span class="ml-2">Emocional</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_personal[]" value="Fisico" class="form-checkbox">
                    <span class="ml-2">Físico</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_personal[]" value="Profesional" class="form-checkbox">
                    <span class="ml-2">Profesional</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="impacto_personal[]" value="Otro" class="form-checkbox">
                    <span class="ml-2">Otro</span>
                </label>
            </div>
            <input type="text" name="impacto_personal_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Acción esperada -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Qué acción espera que tome la empresa?</label>
            <div class="mt-2 space-y-2">
                <label class="block">
                    <input type="checkbox" name="accion_esperada[]" value="Investigación Interna" class="form-checkbox">
                    <span class="ml-2">Investigación Interna</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="accion_esperada[]" value="Mediación" class="form-checkbox">
                    <span class="ml-2">Mediación</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="accion_esperada[]" value="Otra" class="form-checkbox">
                    <span class="ml-2">Otra</span>
                </label>
            </div>
            <input type="text" name="accion_esperada_otra" placeholder="Especifique si eligió 'Otra'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Adjuntar evidencia -->
        <div>
            <label class="block text-gray-700 font-semibold">Si cuenta con archivos que respalden su denuncia, puede adjuntarlos (Evidencia)</label>
            <input type="file" name="evidencia[]" multiple class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>

        <!-- Botón de envío -->
        <div class="text-center">
            <button type="submit" class="bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800">
                Enviar Denuncia
            </button>
        </div>
    </form>
</div>
</body>
</html>

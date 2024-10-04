<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estado de su denuncia actualizado</title>
</head>
<body>
<h1>Estimado {{ $denuncia->nombre_completo }}</h1>

<p>Queremos informarle que el estado de su denuncia con identificador <strong>{{ $denuncia->identificador }}</strong> ha sido actualizado.</p>

<p>El nuevo estado es: <strong>{{ ucfirst($nuevoEstado) }}</strong></p>

<p>Si desea más información, puede acceder a nuestro portal y revisar el estado completo de su denuncia.</p>

<p>Gracias por usar nuestro sistema de denuncias.</p>

<p>Saludos, <br> El equipo de {{ config('app.name') }}</p>
</body>
</html>

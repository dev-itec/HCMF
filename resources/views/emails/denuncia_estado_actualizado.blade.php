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

<p>
    Puede consultar el estado de su denuncia en el siguiente enlace:<br><br><br>
    <a href="{{ url('/denuncia/status?numero=' . $denuncia->identificador . '&clave=' . $denuncia->clave) }}" style="background-color: #186e80; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Ver estado de la denuncia
    </a>
</p>

<p>Gracias por usar nuestro sistema de denuncias.</p>

<p>Saludos, <br> El equipo de {{ config('app.name') }}</p>
</body>
</html>

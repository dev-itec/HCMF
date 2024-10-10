<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Denuncia Recibida</title>
</head>
<body>
<h1>Denuncia recibida</h1>

<p>Estimada/o {{ $nombre_completo }},</p>

<p>El día de hoy, {{ $fecha }}, a las {{ $hora }}, hemos recibido exitosamente su denuncia sobre {{ json_encode($tipo_denuncia) }}. Esta denuncia ha sido asignada a un especialista quien le dará oportuna respuesta.</p>

<p>Identificador: {{$identificador}}</p>
<p>Clave: {{$clave}}</p>

@if($dynamicText)
    <p>
        {{ $dynamicText->texto }}
    </p>
@endif

<p>
    Puede consultar el estado de su denuncia en el siguiente enlace:<br><br><br>
    <a href="{{ url('/denuncia/status?numero=' . $identificador . '&clave=' . $clave) }}" style="background-color: #186e80; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Ver estado de la denuncia
    </a>
</p>

<p>Gracias por su confianza,</p>
<p>El equipo de atención a denuncias</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caso Cerrado</title>
</head>
<body>
<h1>Caso Cerrado: Denuncia {{ $denuncia->identificador }}</h1>
<p>Estimado(a), {{$denuncia->nombre_completo}}</p>
<p>El día de hoy, hemos alcanzado una resolución con respecto a su denuncia con id: <strong>{{ $denuncia->identificador }}</strong> sobre
    {{ implode(', ', $denuncia->tipo_denuncia) }}</p>
<p>Puede ver la resolución final en su portal de denuncias.<p>
    Puede consultar el estado de su denuncia en el siguiente enlace:<br><br><br>
    <a href="{{ url('/denuncia/status?numero=' . $denuncia->identificador . '&clave=' . $denuncia->clave) }}" style="background-color: #186e80; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Ver estado de la denuncia
    </a>
</p>
<p>Gracias,</p>
<p>Equipo de Gestión de Denuncias</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
</head>
<body>
<h1>¡Bienvenido, {{ $userName }}!</h1>
<p>
    Ya eres parte del comite de denuncias.
</p>
<p>
<ul>
    <li>Usuario: {{ $userEmail }}</li>
    <li>Contraseña: {{ $plainPassword }}</li>
</ul>
</p>
<p>Saludos, <br> El equipo de Denuncias.</p>
</body>
</html>


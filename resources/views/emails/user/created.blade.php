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
<p>Puedes acceder al portal de denuncias en el siguiente enlace:<p>
    <br>
    <a href="{{ url('/login') }}" style="background-color: #186e80; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Ir al Canal de denuncias
    </a>
</p>
<p>Saludos, <br> El equipo de Denuncias.</p>
</body>
</html>


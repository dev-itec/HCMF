<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Denuncia {{ $denuncia->identificador }}</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray;
        }

        /* Márgenes para el contenido del documento */
        body {
            margin: 40px; /* Márgenes de 40px alrededor de todo el documento */
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: gray;
        }
    </style>
</head>
<body>

<!-- El contenido del PDF -->
<table width="100%">
    <tr>
        <td valign="top"><img style="width: 35%" src="{{ $src }}" alt="Logo HCM"></td>
        <td align="right">
            <h3>Denuncia {{ $denuncia->identificador }}</h3>
            <pre>
                Denunciante: {{$denuncia->nombre_completo}}
                Estado: {{$denuncia->status}}
                Tipo Denuncia: {{ implode(', ', $denuncia->tipo_denuncia) }}
                Correo Electrónico: {{$denuncia->correo_electronico}}
                Responsable: {{$denuncia->responsable}}
            </pre>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><strong>Fecha de denuncia:</strong> {{$denuncia->created_at}}</td>
    </tr>
    <tr>
        <td><strong>Denunciado:</strong> {{$denuncia->personas_involucradas}}</td>
    </tr>
    <tr>
        <td><strong>Lugar del incidente:</strong> {{$denuncia->lugar_incidente}}</td>
    </tr>
    <tr>
        <td><strong>Detalle del incidente:</strong> {{$denuncia->descripcion_caso}}</td>
    </tr>
    @if($showComment)
        <tr>
            <td><strong>Resolución:</strong> {{$texto_resolucion}}</td>
        </tr>
    @endif
</table>

<!-- Pie de página -->
<div class="footer">
    Generado el {{ now()->format('d-m-Y') }}
</div>

</body>
</html>

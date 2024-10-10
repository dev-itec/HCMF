<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncia PDF</title>

    <!-- Incluir la fuente Maven Pro desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
            color: #333;
        }

        h6 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section span {
            font-weight: bold;
            text-transform: uppercase;
        }

        .col-span-2 {
            margin-top: 15px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .section-header {
            font-weight: 700;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="section-header text-center">Detalles de la Denuncia</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-4"> <!-- Cambiar de col-sm a col-md-4 para hacer 3 columnas -->
                <div class="section">
                    <h6>Denunciante:</h6>
                    <span>{{ $denuncia->nombre_completo }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>R.U.T:</h6>
                    <span>{{ $denuncia->rut }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Género:</h6>
                    <span>{{ $denuncia->genero }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section">
                    <h6>Cargo:</h6>
                    <span>{{ $denuncia->cargo }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Correo electrónico:</h6>
                    <span>{{ $denuncia->correo_electronico }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Relación con la empresa:</h6>
                    <span>{{ $denuncia->relacion }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section">
                    <h6>Tipo de Denuncia:</h6>
                    <span>{{ implode(', ', $denuncia->tipo_denuncia) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Fecha Aproximada:</h6>
                    <span>{{ $denuncia->fecha_aproximada }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Hora del Incidente:</h6>
                    <span>{{ $denuncia->hora_incidente }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section">
                    <h6>Lugar del Incidente:</h6>
                    <span>{{ $denuncia->lugar_incidente }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Persona(s) Involucrada(s):</h6>
                    <span>{{ $denuncia->personas_involucradas }}</span>
                </div>

            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Hora del Incidente:</h6>
                    <span>{{ $denuncia->hora_incidente }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <h6>Descripción del Caso o Denuncia:</h6>
        <span>{{ $denuncia->descripcion_caso }}</span>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section">
                    <h6>Testigos:</h6>
                    <span>{{ $denuncia->testigos }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>¿Cómo se dio cuenta de esta situación?:</h6>
                    <span>{{ $denuncia->como_se_entero }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Impacto en la Empresa:</h6>
                    <span>{{ implode(', ', $denuncia->impacto_empresa) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section">
                    <h6>Impacto Personal:</h6>
                    <span>{{ implode(', ', $denuncia->impacto_personal) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Acción Esperada:</h6>
                    <span>{{ implode(', ', $denuncia->accion_esperada) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section">
                    <h6>Fecha de Denuncia:</h6>
                    <span>{{ $denuncia->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h6>Estado Actual:</h6>
        <span>{{ ucfirst($denuncia->status) }}</span>
    </div>
</div>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

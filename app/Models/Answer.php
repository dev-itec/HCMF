<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    // Campos que se pueden llenar mediante asignación masiva
    protected $fillable = [
        'identificador',
        'clave',
        'nombre_completo',
        'rut',
        'genero',
        'cargo',
        'correo_electronico',
        'relacion',
        'tipo_denuncia',
        'detalles_incidente',
        'fecha_exacta',
        'fecha_aproximada',
        'hora_incidente',
        'lugar_incidente',
        'descripcion_caso',
        'personas_involucradas',
        'testigos',
        'como_se_entero',
        'como_se_entero_otro',
        'impacto_empresa',
        'impacto_empresa_otro',
        'impacto_personal',
        'impacto_personal_otro',
        'accion_esperada',
        'accion_esperada_otra',
        'evidencia',
        'responsable',
        'status',
    ];

    // Para manejar los campos de tipo JSON
    protected $casts = [
        'tipo_denuncia' => 'array',
        'impacto_empresa' => 'array',
        'impacto_personal' => 'array',
        'accion_esperada' => 'array',
        'evidencia' => 'array',
    ];
    public function resolucion()
    {
        return $this->hasMany(Resolucion::class, 'denuncia_id');
    }
}

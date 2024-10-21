<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',          // El campo del formulario
        'type',           // El tipo de campo
        'category',       // La categoría del campo
        'active',         // Si el campo está activo o no
        'additional_info' // Información adicional sobre el campo
    ];
}

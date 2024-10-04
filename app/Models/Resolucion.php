<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resolucion extends Model
{
    protected $table = 'resolucion';
    use HasFactory;

    protected $fillable = [
        'denuncia_id',
        'identificador',
        'texto_resolucion',
        'pdf',
    ];

    // Define la relación con el modelo Denuncia si es necesario
    public function denuncia()
    {
        return $this->belongsTo(Answer::class);
    }
}

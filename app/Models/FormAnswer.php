<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;
    protected $table = 'form_answers';

    protected $fillable = [
        'ans_text',       // texto de la respuesta
        'question_id',    // ID de la pregunta asociada
        'denuncia_id',    // ID de la denuncia asociada
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }
}

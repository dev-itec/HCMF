<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = ['answer_id', 'old_status', 'new_status', 'changed_by'];

    // Relación con la denuncia
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    // Relación con el usuario que cambió el estado (si aplicable)
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = ['label', 'name', 'type', 'options', 'order', 'required'];

    protected $casts = [
        'options' => 'string',
    ];

    /**
     * Accesor para obtener las opciones como un array.
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Mutador para guardar las opciones como JSON.
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }
}

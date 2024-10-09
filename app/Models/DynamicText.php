<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicText extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'seccion',
    ];
}

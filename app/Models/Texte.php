<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Texte extends Model
{
    use HasFactory;
    protected $fillable = [
        'questions',
        'answers',
        'user_input',
        'position',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nachrichten extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'position',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNachricht extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nachricht_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_nachricht';
}

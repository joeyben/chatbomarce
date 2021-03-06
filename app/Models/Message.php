<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'whatsapp',
        'message',
        'status',
    ];

    public function getWhatsappAttribute() {
        return str_replace('whatsapp:', '', $this->attributes['whatsapp']);
    }
}

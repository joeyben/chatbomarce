<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'whatsapp',
        'last_message',
        'privacy',
    ];

    protected $casts = [
        'last_message' => 'datetime',
    ];

    public function getPrivacyAttribute() {
        if (!$this->attributes['privacy_check']) {
            return 'Noch nicht gesetzt';
        }else if ($this->attributes['privacy']) {
            return 'Akzeptiert';
        }else{
            return 'Abgelehnt';
        }
    }
}

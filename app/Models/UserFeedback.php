<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'feedback_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\WhatsappUser');
    }

    public function feedback()
    {
        return $this->belongsTo('App\Models\Feedback');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_conversations');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

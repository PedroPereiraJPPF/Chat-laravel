<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status'
    ];

    public function users_id()
    {
        return $this->hasMany('users_conversations');
    }
}

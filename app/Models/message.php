<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_conversation',
        'id_sender',
        'content'
    ];

    public function sender()
    {
        return $this->belongsTo('users', 'id', 'id_sender');
    }

    public function conversation()
    {
        return $this->belongsTo('conversations', 'id', 'id_conversation');
    }
}

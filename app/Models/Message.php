<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content' , 'image' , 'lat' , 'lng' , 'is_read' , 'type' , 'chat_id'];

    public function chat()
    {
        return $this->belongsTo(Chat::class , 'chat_id' , 'id');
    }

}

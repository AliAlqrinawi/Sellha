<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['status' , 'sender_id' , 'receiver_id' , 'product_id'];

    public function sender()
    {
        return $this->belongsTo(User::class , 'sender_id' , 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class , 'receiver_id' , 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'chat_id', 'id')->orderBy('id', 'desc');
    }

}

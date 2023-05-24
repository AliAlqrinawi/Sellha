<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['type' , 'status' , 'image' , 'buyer_id' , 'product_id' , 'seller_id'];

    public function getImageAttribute()
    {
        return url('/') . '/' . $this->attributes['image'];
    }

    public function buyer()
    {
        return $this->belongsTo(User::class , 'buyer_id' , 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class , 'seller_id' , 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }
}

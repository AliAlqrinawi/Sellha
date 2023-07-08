<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total' , 'lat' , 'lng' , 'buyer_id' , 'product_id' ,
    'seller_id' , 'status' , 'payment_status'];

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

    public function scopeChangeStatus()
    {
        if ($this->status == 'PENDING') {
            $this->update(['status' => 'PROCESSING']);
        }elseif($this->status == 'PROCESSING'){
            $this->update(['status' => 'DELIVERING']);
        }elseif($this->status == 'DELIVERING'){
            $this->update(['status' => 'COMPLETED']);
        }elseif($this->status == 'COMPLETED'){
            $this->update(['status' => 'CANCELLED']);
        }elseif($this->status == 'CANCELLED'){
            $this->update(['status' => 'REFUNDED']);
        }elseif($this->status == 'REFUNDED'){
            $this->update(['status' => 'PROCESSING']);
        } else {
            $this->update(['status' => 'PENDING']);
        }
    }
}

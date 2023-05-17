<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denouncement extends Model
{
    use HasFactory;

    protected $fillable = ['reason' , 'product_id' , 'user_id'];
}

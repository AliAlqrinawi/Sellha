<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_name' , 'email' , 'avatar' , 'lat' , 'lng' , 'about' , 'distance' , 'user_id'];
}

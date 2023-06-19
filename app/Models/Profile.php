<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_name' , 'email' , 'avatar' , 'lat' , 'lng' , 'about' , 'distance' , 'user_id' , 'notification_flag'];


    public function getAvatarAttribute()
    {
        return Request::root('/') . '/' . $this->attributes['avatar'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

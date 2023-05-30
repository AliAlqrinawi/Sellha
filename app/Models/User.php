<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name' , 'email' , 'type' , 'phone' , 'otp' , 'status' , 'verification' , 'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class , 'seller_id');
    }

    public function scopeChangeStatus()
    {
        if($this->status == "ACTIVE"){
            $this->update(['status' => 'INACTIVE']);
        }else{
            $this->update(['status' => 'ACTIVE']);
        }
    }

    public function roles(){
        return $this->belongsToMany(Role::class , 'role_users');
    }

    public function permissions($permissions)
    {
        foreach($this->roles as $role){
            if(in_array($permissions ,  $role->permissions)){
                return true;
            }
            else{
                return false;
            }
        }
    }
}

<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;

    protected $fillable = ['reason_ar' , 'reason_en' , 'status'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }
}

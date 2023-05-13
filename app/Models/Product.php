<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('test' , function($query){
            $locale = app()->getLocale();
            return $query->select('*' , "title_$locale as title" , "description_$locale as description");
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

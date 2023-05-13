<?php

namespace App\Models;

use App\Models\Scopes\GetDataByLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new GetDataByLanguage);
    }

    // public function scopeWithTranslatedTitle($query)
    // {
    //     $locale = app()->getLocale();
    //     return $query->select('*', "title_$locale as title");
    // }
}

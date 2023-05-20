<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\GetDataByLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class , 'parent_id' , 'id');
    }
}

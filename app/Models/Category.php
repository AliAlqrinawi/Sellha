<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\GetDataByLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar' , 'title_en' , 'image' , 'status' , 'parent_id'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function sub_category()
    {
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'parent_id' , 'id');
    }

    public function scopeChangeStatus()
    {
        if($this->status == "ACTIVE"){
            $this->update(['status' => 'INACTIVE']);
        }else{
            $this->update(['status' => 'ACTIVE']);
        }
    }
}

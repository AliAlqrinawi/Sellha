<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar' , 'title_en' , 'file' , 'price' , 'discount' , 'is_sale' , 'description_ar'
    , 'description_en' , 'lat' , 'lng' , 'type' , 'category_id' , 'sub_category_id'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class , 'sub_category_id' , 'id');
    }

    public function favorite()
    {
        return $this->hasOne(Favorite::class , 'product_id' , 'id')->where('user_id' , Auth::user()->id);
    }

    public function all_favorite()
    {
        return $this->hasMany(Favorite::class , 'product_id' , 'id');
    }

    public function files()
    {
        return $this->hasMany(File::class , 'product_id' , 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class , 'product_id' , 'id');
    }
}

<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en', 'file', 'price', 'discount', 'is_sale', 'description_ar', 'description_en', 'lat', 'lng', 'views', 'is_sale', 'type', 'status', 'show', 'category_id', 'sub_category_id', 'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }

    public function favorite()
    {
        return $this->hasOne(Favorite::class, 'product_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function all_favorite()
    {
        return $this->hasMany(Favorite::class, 'product_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'product_id', 'id');
    }

    public function getFileAttribute()
    {
        return Request::root('/') . '/' . $this->attributes['file'];
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $filters = array_merge([], $filters);

        $builder->when($filters['name'], function ($builder, $value) {
            $builder->where('title_ar', 'like', '%' . $value . '%')
                ->orWhere('title_en', 'like', '%' . $value . '%');
        });

        $builder->when($filters['type'], function ($builder, $value) {
            $builder->where('type', $value);
        });

        $builder->when($filters['postingTime'], function ($builder, $value) {
            $weekAgo = Carbon::now()->subWeek();
            $monthAgo = Carbon::now()->subMonth();
            $last24Hours = Carbon::now()->subDay();
            if ($value == '24') {
                $builder->whereBetween('created_at', [$last24Hours, Carbon::now()]);
            } elseif ($value == 'week') {
                $builder->whereBetween('created_at', [$weekAgo, Carbon::now()]);
            } elseif ($value == 'month') {
                $builder->whereBetween('created_at', [$monthAgo, Carbon::now()]);
            }
        });

        $builder->when($filters['categories'], function ($builder, $value) {
            $builder->whereHas('category', function ($builder, $value) {
                $ids = json_decode($value);
                $builder->whereIn('id', $ids);
            });
        });

        $builder->when($filters['subCategories'], function ($builder, $value) {
            $builder->whereHas('sub_category', function ($builder, $value) {
                $ids = json_decode($value);
                $builder->whereIn('id', $ids);
            });
        });

        $builder->when($filters['from'], function ($builder, $value) {
            $builder->where('price', '>=', $value);
        });

        $builder->when($filters['to'], function ($builder, $value) {
            $builder->where('price', '<=', $value);
        });

        $builder->when($filters['myFavorite'], function ($q) {
            $q->whereHas('favorite', function ($q) {
                $q->where('user_id', Auth::user()->id);
            });
        });

        $builder->when($filters['mySales'], function ($q) {
            $q->whereHas('order', function ($q) {
                $q->where('status', 'COMPLETED')->where('seller_id', Auth::user()->id);;
            });
        });

        $builder->when($filters['myProducts'], function ($q) {
            $q->where('user_id', Auth::user()->id);
        });

        $builder->when($filters['myPurchases'], function ($q) {
            $q->whereHas('order', function ($q) {
                $q->where('status', 'COMPLETED')->where('buyer_id', Auth::user()->id);
            });
        });

    }

    public function scopeChangeStatus()
    {
        if ($this->status == "ACTIVE") {
            $this->update(['status' => 'INACTIVE']);
        } else {
            $this->update(['status' => 'ACTIVE']);
        }
    }

    function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earthRadius = 6371; // Radius of the Earth in kilometers

        // Convert latitude and longitude from degrees to radians
        $latFrom = deg2rad($latitude1);
        $lonFrom = deg2rad($longitude1);
        $latTo = deg2rad($latitude2);
        $lonTo = deg2rad($longitude2);

        // Calculate the differences between the coordinates
        $latDiff = $latTo - $latFrom;
        $lonDiff = $lonTo - $lonFrom;

        // Apply the Haversine formula
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($latFrom) * cos($latTo) * sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}

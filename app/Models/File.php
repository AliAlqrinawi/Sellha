<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = ['file' , 'product_id'];

    public function getFileAttribute()
    {
        return Request::root('/') . '/' . $this->attributes['file'];
    }
}

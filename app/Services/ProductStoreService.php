<?php

namespace App\Services;

use App\Models\File;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductStoreService
{
    public function handle($data)
    {
        DB::beginTransaction();
        try {
            if ($data->file('image')) {
                $name = Str::random(12);
                $path = $data->file('image');
                $name = $name . time() . '.' . $data->file('image')->getClientOriginalExtension();
                $path->move('uploads/products/', $name);
                $data['file'] = 'uploads/products/' . $name;
            }
            if ($data->file('video')) {
                $name = Str::random(12);
                $path = $data->file('video');
                $name = $name . time() . '.' . $data->file('video')->getClientOriginalExtension();
                $path->move('uploads/products/', $name);
                $data['file'] = 'uploads/products/' . $name;
            }
            $data['user_id'] = Auth::user()->id;
            $product = Product::create($data);
            if ($data->hasFile('files')) {
            $files = $data->file('files');
            foreach($files as $file){
                $name = Str::random(12);
                $path = $file;
                $name = $name . time() . '.' . $file->getClientOriginalExtension();
                $path->move('uploads/products/', $name);
                $datafile = 'uploads/products/' . $name;
                File::create([
                    'file' => $datafile,
                    'product_id' => $product->id,
                ]);
            }
        }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

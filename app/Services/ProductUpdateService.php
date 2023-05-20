<?php

namespace App\Services;

use App\Models\File;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductUpdateService
{
    public function handle($data , $id)
    {
        DB::beginTransaction();
        try {
            $data['file'] = "0";
            if (isset($data['image'])) {
                $name = Str::random(12);
                $path = $data['image'];
                $name = $name . time() . '.' . $data['image']->getClientOriginalExtension();
                $path->move('uploads/products/', $name);
                $data['file'] = 'uploads/products/' . $name;
            }
            if (isset($data['video'])) {
                $name = Str::random(12);
                $path = $data['video'];
                $name = $name . time() . '.' . $data['video']->getClientOriginalExtension();
                $path->move('uploads/products/', $name);
                $data['file'] = 'uploads/products/' . $name;
            }
            $data['user_id'] = Auth::user()->id;
            $product = Product::find($id);
            $product->update($data);
            if (isset($data['files'])) {
            $files = $data['files'];
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

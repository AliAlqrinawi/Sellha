<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $categories = Category::
        when($request->name, function($q) use ($request) {
            $q->where('title_ar', 'like', '%' . $request->name . '%')
            ->orWhere('title_en' , 'like' , '%'. $request->name . '%');
        })
        ->with('sub_category')->get();
        return (new CategoryCollection($categories));
    }
}

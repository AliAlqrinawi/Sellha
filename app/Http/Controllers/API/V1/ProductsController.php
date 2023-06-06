<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\ProductStore;
use App\Http\Resources\ProductCollection;
use App\Models\File;
use App\Models\Product;
use App\Services\ProductStoreService;
use App\Services\ProductUpdateService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::
        when($request->name, function($q) use ($request) {
            $q->where('title_ar', 'like', '%' . $request->name . '%')
            ->orWhere('title_en' , 'like' , '%'. $request->name . '%');
        })
        ->when($request->type, function($q) use ($request) {
            $q->where('type' , $request->type);
        })
        ->when($request->postingTime, function($q) use ($request) {
            $weekAgo = Carbon::now()->subWeek();
            $monthAgo = Carbon::now()->subMonth();
            $last24Hours = Carbon::now()->subDay();
            if($request->postingTime == '24'){
                $q->whereBetween('created_at', [$last24Hours, Carbon::now()]);
            }elseif($request->postingTime == 'week'){
                $q->whereBetween('created_at', [$weekAgo, Carbon::now()]);
            }elseif($request->postingTime == 'month'){
                $q->whereBetween('created_at', [$monthAgo, Carbon::now()]);
            }
        })
        ->when($request->categories, function($builder) use ($request) {
            $builder->whereHas('category' , function($q) use ($request){
                $ids = json_decode($request->categories);
                $q->whereIn('id', $ids);
            });
        })
        ->when($request->subCategories, function($builder) use ($request) {
            $builder->whereHas('sub_category' , function($q) use ($request){
                $ids = json_decode($request->subCategories);
                $q->whereIn('id', $ids);
            });
        })
        ->when($request->from, function($q) use ($request) {
            $q->whereBetween('price', [intval($request->form) , intval($request->to)]);
        })
        ->when($request->lat, function($q) use ($request) {
            $q->where('lat', $request->lat);
        })
        ->when($request->lng, function($q) use ($request) {
            $q->where('lng', $request->lng);
        })
        ->when($request->myFavorite, function($q) {
            $q->whereHas('favorite' , function($q){
                $q->where('user_id' , Auth::user()->id);
            });
        })
        ->when($request->mySales, function($q) {
            $q->whereHas('order' , function($q){
                $q->where('status' , 'COMPLETED');
            });
        })
        ->orderBy('id' , 'desc')
        ->with('category' , 'sub_category' , 'favorite' , 'files' , 'order')->get();
        return (new ProductCollection($products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStore $productStore , ProductStoreService $productStoreService)
    {
        $data = $productStore->all();
        try {
            $productStoreService->handle($data);
            return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS', 200);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= Product::with('category' , 'sub_category'
        , 'favorite' , 'files' , 'all_favorite')->find($id);
        return parent::success($product , Messages::getMessage('operation accomplished successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStore $productStore, ProductUpdateService $productUpdateService , $id)
    {
        $data = $productStore->all();
        try {
            $productUpdateService->handle($data , $id);
            return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS', 200);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS', 200);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $product = Product::find($id);
        $product->views = $product->views + 1;
        $product->update();

        return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS', 200);
    }
}

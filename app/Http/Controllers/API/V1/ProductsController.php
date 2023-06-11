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
            filter([
                'name' => $request->name,
                'type' => $request->type,
                'postingTime' => $request->postingTime,
                'from' => $request->from,
                'to' => $request->to,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'categories' => $request->categories,
                'subCategories' => $request->subCategories,
                'myFavorite' => $request->myFavorite,
                'mySales' => $request->mySales,
                'myProducts' => $request->myProducts,
                'myPurchases' => $request->myPurchases,
            ])
            ->orderBy('id', 'desc')
            ->with('category', 'sub_category', 'favorite', 'files', 'order')->get();
            if($request->SortByDistance == 'closest'){
                $products =  $this->getClosestLocations(Auth::user()->profile->lat , Auth::user()->profile->lng , 'closest');
            }
            if($request->SortByDistance == 'furthest'){
                $products =  $this->getClosestLocations(Auth::user()->profile->lat , Auth::user()->profile->lng , 'furthest');
            }
        return (new ProductCollection($products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStore $productStore, ProductStoreService $productStoreService)
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
        $product = Product::with(
            'category',
            'sub_category',
            'favorite',
            'files',
            'all_favorite'
        )->find($id);
        return parent::success($product, Messages::getMessage('operation accomplished successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStore $productStore, ProductUpdateService $productUpdateService, $id)
    {
        $data = $productStore->all();
        try {
            $productUpdateService->handle($data, $id);
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

    public function getClosestLocations($targetLatitude, $targetLongitude , $distance)
    {
        $locations = Product::get(); // Retrieve all locations from the database
        
        // Calculate distances and add them to the locations
        foreach ($locations as $key => $location) {
            $location->distance = $this->calculateDistance($targetLatitude, $targetLongitude, $location->lat, $location->lng);
        }

        // Sort locations based on distance
        if($distance == 'closest'){
            $locations = $locations->sortBy('distance');
        }else{
            $locations = $locations->sortByDesc('distance');
        }

        return $locations->values()->all();
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

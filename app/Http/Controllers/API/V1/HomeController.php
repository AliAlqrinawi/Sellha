<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $ads = Ad::where('status' , 'ACTIVE')->orderBy('id' , 'desc')->get();

        $categories = Category::where(['status' => 'ACTIVE' , 'parent_id' => null])->orderBy('id' , 'desc')->get();

        $productsBestDeals = Product::with('user' , 'category' , 'sub_category' , 'favorite' , 'files')->where(['status' => 'ACTIVE' , 'show' => 'BEST-DEALS'])->orderBy('id' , 'desc')->get();

        $products = Product::with('user' , 'category' , 'sub_category' , 'favorite' , 'files')->where(['status' => 'ACTIVE' , 'show' => null])->orderBy('id' , 'desc')->get();

        $data = [
            'ads' => $ads,
            'categories' => $categories,
            'productsBestDeals' => $productsBestDeals,
            'products' => $products,
        ];

        return parent::success($data , Messages::getMessage('operation accomplished successfully'));
    }
}

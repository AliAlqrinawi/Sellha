<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\OrderStore;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderStoreService;
use Illuminate\Http\Request;
use Throwable;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('buyer' , 'seller' , 'product')->get();
        return (new OrderCollection($orders))->additional(['code' => 200 , 'status' => true, 'message' => Messages::getMessage('operation accomplished successfully')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStore $orderStore , OrderStoreService $orderStoreService)
    {
        $data = $orderStore->all();
        try {
            $orderStoreService->handle($data);
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
        $order = Order::with('buyer' , 'seller' , 'product')->find($id);
        return parent::success($order , Messages::getMessage('operation accomplished successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

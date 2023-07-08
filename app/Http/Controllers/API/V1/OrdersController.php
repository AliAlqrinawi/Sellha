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
            return $orderStoreService->handle($data);
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

    public function createPaymentLink(OrderStoreService $orderStoreService , $id)
    {
        try {
            return $orderStoreService->createPaymentLink($id);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendIdForPayment(OrderStoreService $orderStoreService , $id , $idOrder)
    {
        try {
            return $orderStoreService->sendIdForPayment($id , $idOrder);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

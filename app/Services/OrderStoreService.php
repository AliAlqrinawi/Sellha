<?php

namespace App\Services;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderStoreService extends Controller
{
    public function handle($data)
    {
        DB::beginTransaction();
        try {
            $order = Order::create($data);
            $data = [
                "paymentLink" => route('createPaymentLink' , $order->id),
            ];
            DB::commit();
            return parent::success($data , Messages::getMessage('operation accomplished successfully'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createPaymentLink($id)
    {
        $order = Order::find($id);
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174d0595bb014d05d82e5b01d2" .
            "&amount=$order->total" .
            "&currency=SAR" .
            "&paymentType=DB" .
            "&standingInstruction.source=CIT" .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData);
        return view('pay', compact('responseData'));
    }

    public function sendIdForPayment($id)
    {
        $url = "https://test.oppwa.com/v1/checkouts/$id/payment";
        $url .= "?entityId=8a8294174d0595bb014d05d82e5b01d2";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }
}

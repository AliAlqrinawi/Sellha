<?php

namespace App\Services;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Models\Order;
use Illuminate\Http\Request;
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
                "paymentLink" => route('createPaymentLink', $order->id),
                "order" => $order,
            ];
            DB::commit();
            return parent::success($data, Messages::getMessage('operation accomplished successfully'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createPaymentLink($id)
    {
        $order = Order::find($id);
        $entityId = "8ac7a4c78920530a018920bd7180011d";
        $type = "VISA MASTER";
        if ($order->payment_type == "MADA") {
            $type = "MADA";
            $entityId = "8ac7a4c78920530a018920be0ed20121";
        } else if ($order->payment_type == "VISA") {
            $type = "VISA";
            $entityId = "8ac7a4c78920530a018920bd7180011d";
        } else if ($order->payment_type == "MASTER") {
            $type = "MASTER";
            $entityId = "8ac7a4c78920530a018920bd7180011d";
        }else if($order->payment_type == "APPLEPAY"){
            $type = "APPLEPAY";
            $entityId = "8ac7a4ca8a69d057018a69da4bf20024";
        }
        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=$entityId" .
            "&amount=$order->total" .
            "&currency=SAR" .
            "&paymentType=DB" .
            "&standingInstruction.source=CIT" .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc4OTIwNTMwYTAxODkyMGJjZGEyMDAxMTl8ZzVoc0E2d3c5dw=='
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
        return view('pay', compact('responseData', 'order', 'type'));
    }

    public function sendIdForPayment($id, $idOrder)
    {
        $order = Order::find($idOrder);
        $entityId = "8ac7a4c78920530a018920bd7180011d";
        if ($order->payment_type == "MADA") {
            $entityId = "8ac7a4c78920530a018920be0ed20121";
        } else if ($order->payment_type == "VISA") {
            $entityId = "8ac7a4c78920530a018920bd7180011d";
        } else if ($order->payment_type == "MASTER") {
            $entityId = "8ac7a4c78920530a018920bd7180011d";
        }else if($order->payment_type == "APPLEPAY"){
            $entityId = "8ac7a4ca8a69d057018a69da4bf20024";
        }
        $url = "https://eu-test.oppwa.com/v1/checkouts/$id/payment";
        $url .= "?entityId=$entityId";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc4OTIwNTMwYTAxODkyMGJjZGEyMDAxMTl8ZzVoc0E2d3c5dw=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData);
        if (
            $responseData->result->code == "000.000.000" || $responseData->result->code == "000.000.100" ||
            $responseData->result->code == "000.100.105" || $responseData->result->code == "000.100.106" ||
            $responseData->result->code == "000.100.110" || $responseData->result->code == "000.100.111"
            || $responseData->result->code == "000.100.112" || $responseData->result->code == "000.300.000"
            || $responseData->result->code == "000.300.100" || $responseData->result->code == "000.300.101"
            || $responseData->result->code == "000.300.102" || $responseData->result->code == "000.300.103"
            || $responseData->result->code == "000.310.100" || $responseData->result->code == "000.310.101"
            || $responseData->result->code == "000.310.110" || $responseData->result->code == "000.400.110"
            || $responseData->result->code == "000.400.120" || $responseData->result->code == "000.600.000"
        ) {
            $order->update(['payment_status' => 'PAID']);
            $order->save();
            return redirect()->route("statusPayment", [$order->id, "PAID"]);
            return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS', 200);
        } else {
            $order->update(['payment_status' => 'FAILED']);
            $order->save();
            return redirect()->route("statusPayment", [$order->id, "FAILED"]);
            return ControllersService::generateProcessResponse(false, 'CREATE_FAILED', 200);
        }
    }
}

<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderStoreService
{
    public function handle($data)
    {
        DB::beginTransaction();
        try {
            Order::create($data);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

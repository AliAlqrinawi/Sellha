<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class OrderStoreService
{
    public function handle($data)
    {
        DB::beginTransaction();
        try {

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }   
    }
}

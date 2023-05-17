<?php

namespace App\Http\Resources;

use App\Helpers\Messages;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public $collects = ProductResource::class;

    public function toArray($request)
    {
        return [
            'code' => 200,
            'status' => true,
            'message' => Messages::getMessage('operation accomplished successfully'),
            'data' => $this->collection,
        ];
    }
}

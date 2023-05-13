<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    public $collects = NotificationResource::class;

    public function toArray($request)
    {
        return [
            'code' => 200,
            'status' => true,
            'message' => 'تمت العملية بنجاح',
            'data' => $this->collection,
        ];
    }
}

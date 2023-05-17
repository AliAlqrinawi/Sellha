<?php

namespace App\Http\Resources;

use App\Helpers\Messages;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DenouncementCollection extends ResourceCollection
{
    public $collects = DenouncementResource::class;

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

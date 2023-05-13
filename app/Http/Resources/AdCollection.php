<?php

namespace App\Http\Resources;

use App\Helpers\Messages;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
{
    public $collects = AdResource::class;
    
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

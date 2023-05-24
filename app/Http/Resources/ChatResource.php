<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'image' => $this->image,
            'buyer_id' => $this->buyer_id,
            'product_id' => $this->product_id,
            'seller_id'=> $this->seller_id,
            'created_at'=> $this->created_at,
            'buyer' => new UserResource($this->whenLoaded('buyer')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'seller' => new UserResource($this->whenLoaded('seller')),
        ];
    }
}

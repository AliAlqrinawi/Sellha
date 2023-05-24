<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'total' => $this->total,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'buyer_id' => $this->buyer_id,
            'product_id' => $this->product_id,
            'seller_id' => $this->seller_id,
            'created_at' => $this->created_at,
            'buyer' => new UserResource($this->whenLoaded('buyer')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'seller' => new UserResource($this->whenLoaded('seller')),
        ];
    }
}

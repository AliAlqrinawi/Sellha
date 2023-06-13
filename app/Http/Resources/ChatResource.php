<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'sender_id' => $this->sender_id,
            'product_id' => $this->product_id,
            'receiver_id'=> $this->receiver_id,
            'created_at'=> $this->created_at,
            'sender' => new UserResource($this->whenLoaded('sender')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'receiver' => new UserResource($this->whenLoaded('receiver')),
            'lastMessage' => new MessageResource($this->whenLoaded('lastMessage')),
        ];
    }
}

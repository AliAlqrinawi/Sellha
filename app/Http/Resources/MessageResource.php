<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'image' => $this->image,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'is_read' => $this->is_read,
            'type' => $this->type,
            'sender_id' => $this->sender_id,
            'product_id' => $this->product_id,
            'receiver_id' => $this->receiver_id,
            'chat_id' => $this->chat_id,
            'created_at' => $this->created_at,
            'chat' => new ChatResource($this->whenLoaded('chat')),
        ];
    }
}

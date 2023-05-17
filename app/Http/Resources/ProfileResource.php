<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id' => $this->id,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'about' => $this->about,
            'distance' => $this->distance,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'user' =>  new UserResource($this->whenLoaded('user')),
        ];
    }
}

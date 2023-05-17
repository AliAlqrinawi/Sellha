<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'image' => $this->image,
            'price' => $this->price,
            'discount' => $this->discount,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'views' => $this->views,
            'lat' => $this->lat,
            'lng' => $this->lng	,
            'show' => $this->show,
            'is_sale' => $this->is_sale,
            'type' => $this->type,
            'status' => $this->status,
            'category_id ' => $this->category_id,
            'sub_category_id ' => $this->sub_category_id,
            'order' =>  new OrderResource($this->whenLoaded('order')),
            'category' =>  new CategoryResource($this->whenLoaded('category')),
            'sub_category' =>  new CategoryResource($this->whenLoaded('sub_category')),
            'files' =>  new FileCollection($this->whenLoaded('files')),
            'favorite' =>  new FavoriteResource($this->whenLoaded('favorite')),
        ];
    }
}

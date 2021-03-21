<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class Challenge extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'published_at' => $this->published_at,
            'category_id' => $this->category_id,

            'category' => Category::make($this->whenLoaded('category')),

            'banners' => Banner::collection($this->whenLoaded('banners')),
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OtherUser extends JsonResource
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
            'name' => $this->name,
            'profile_photo_path' => $this->getProfilePhotoUrlAttribute(),
        ];
    }
}

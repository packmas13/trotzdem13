<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
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
            'reactionType' => $this->reaction->type,
            'userId' => $this->id,
            'userName' => $this->name,
            'profile_photo_path' => $this->getProfilePhotoUrlAttribute(),
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserTeam extends JsonResource
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
            'join_code' => $this->join_code,
            'image' => empty($this->image) ? null : Storage::disk('upload')->url($this->image),
            'is_approved' => !is_null($this->approved_at),

            'users' => OtherUser::collection($this->whenLoaded('users')),
            'troop' => Troop::make($this->whenLoaded('troop')),
            'district' => Troop::make($this->whenLoaded('district')),
            'banner' => Banner::make($this->whenLoaded('banner')),
            'currentChallenges' => Challenge::collection($this->whenLoaded('currentChallenges')),
        ];
    }
}

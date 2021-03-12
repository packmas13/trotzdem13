<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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

            'users' => OtherUser::collection($this->whenLoaded('users')),
            'stamm' => Stamm::make($this->whenLoaded('stamm')),
            'bezirk' => Stamm::make($this->whenLoaded('bezirk')),
            'stufe' => Stufe::make($this->whenLoaded('stufe')),
        ];
    }
}

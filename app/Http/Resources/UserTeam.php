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
        $isLeader = $request->user()->id == $this->leader_id;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'join_code' => $this->join_code,
            'leader_id' => $this->leader_id,
            'image' => empty($this->image) ? null : Storage::disk('upload')->url($this->image),
            'is_approved' => !is_null($this->approved_at),
            'can_choose_project' => !is_null($this->approved_at),
            'contact_phone' => $this->when($isLeader, $this->contact_phone),
            'contact_email' => $this->when($isLeader, $this->contact_email),
            'contact_name' => $this->when($isLeader, $this->contact_name),
            'contact_street' => $this->when($isLeader, $this->contact_street),
            'contact_zip' => $this->when($isLeader, $this->contact_zip),
            'contact_city' => $this->when($isLeader, $this->contact_city),


            'users' => OtherUser::collection($this->whenLoaded('users')),
            'troop' => Troop::make($this->whenLoaded('troop')),
            'district' => Troop::make($this->whenLoaded('district')),
            'banner' => Banner::make($this->whenLoaded('banner')),
            'currentChallenges' => Challenge::collection($this->whenLoaded('currentChallenges')),
        ];
    }
}

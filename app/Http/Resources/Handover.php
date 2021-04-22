<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Handover extends JsonResource
{
    private $_forLeader = false;

    public function forLeader(bool $state)
    {
        $this->_forLeader = $state;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $nextHandover = $this->nextHandover();

        return [
            'id' => $this->id,
            'variant' => $this->variant,
            'banner' =>  Banner::make($this->whenLoaded('banner')),
            'received_at' => $this->received_at->format('Y-m-d'),


            'team' =>  OtherTeam::make($this->whenLoaded('team'))->withContactDetails($this->_forLeader),

            'previous_team' => OtherTeam::make($this->previousTeam())->withContactDetails($this->_forLeader),

            'next_handover' => [
                'received_at' => $nextHandover->received_at->format('Y-m-d'),
                'team' =>  OtherTeam::make($nextHandover->team)->withContactDetails($this->_forLeader),
            ],
        ];
    }
}

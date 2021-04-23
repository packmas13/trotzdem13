<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OtherTeam extends JsonResource
{
    private $_withContactDetails = false;

    public function withContactDetails(bool $state)
    {
        $this->_withContactDetails = $state;
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
        return[
            'name' => $this->name,
            'image' => empty($this->image) ? null : Storage::disk('upload')->url($this->image),
            'troop' => Troop::make($this->whenLoaded('troop')),
            'district' => Troop::make($this->whenLoaded('district')),

            'contact' => $this->when($this->_withContactDetails, [
                'name'=>$this->contact_name,
                'phone'=>$this->contact_phone,
                'email'=>$this->contact_email,
            ]),
        ];
    }
}

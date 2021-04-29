<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'subject' => $this->subject,
            'content' => $this->content,
            'team_id' => $this->team_id,
            'author_id' => $this->author_id,
            'challenge_id' => $this->challenge_id,
            'banner_id' => $this->banner_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'team' =>  OtherTeam::make($this->whenLoaded('team')),
            'challenge' =>  Challenge::make($this->whenLoaded('challenge')),
            'author' =>  OtherUser::make($this->whenLoaded('author')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'users' => ReactionResource::collection($this->whenLoaded('users')),
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class, 'banner_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reactions')->as('reaction')->withTimestamps()->withPivot('type');
    }

    /**
     * Checks if the current user can edit the post.
     *
     * @param $request
     * @return bool
     */
    public function canEdit($request) {
        $user = $request->user();
        if($this->author_id == $user->id) {
            return true;
        }
        if($this->team->leader_id == $user->id){
            return true;
        }
        if($user->isOrga()){
            return true;
        }
        return false;
    }
}

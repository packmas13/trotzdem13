<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'location' => 'array',
        'approved_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope('with_bezirk', function (Builder $builder) {
            if (is_null($builder->getQuery()->columns)) {
                $builder->addSelect('*');
            }
            $builder->selectRaw('(troop_id / 100)*100 as bezirk_id');
        });
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(Troop::class, 'troop_id');
    }

    public function bezirk(): BelongsTo
    {
        return $this->belongsTo(Troop::class, 'bezirk_id');
    }

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class, 'banner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

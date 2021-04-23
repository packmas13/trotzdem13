<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Handover extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'received_at' => 'date:Y-m-d',
        'variant' => 'integer',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }


    public function previousTeam(): Team
    {
        $handover = static::where([
            'banner_id' => $this->banner_id,
            'variant' => $this->variant,
        ])
            ->where('id', '<>', $this->id)
            ->where('received_at', '<', $this->received_at)
            ->orderBy('received_at', 'desc')
            ->first();
        if ($handover) {
            return $handover->team->load('troop', 'district');
        }
        // will receive from orga-Team if needed
        return Team::findOrFail(42)->load('troop', 'district');
    }

    public function nextHandover(): Handover
    {
        return static::where([
            'banner_id' => $this->banner_id,
            'variant' => $this->variant,
        ])
            ->where('id', '<>', $this->id)
            ->where('received_at', '>', $this->received_at)
            ->orderBy('received_at')
            // will give it to the orga-Team
            ->firstOrNew([], [
                'team_id' => 42,
                'banner_id' => $this->banner_id,
                'variant' => $this->variant,
                'received_at' => '2021-09-18',
            ])->load('team.troop', 'team.district');
    }
}

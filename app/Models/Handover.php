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
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function next_team(): ?Team
    {
        return static::where([
            'banner_id' => $this->banner_id,
        ])
            ->where('received_at', '>', $this->received_at)
            ->orderBy('received_at')
            ->first()->team;
    }
}

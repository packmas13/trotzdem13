<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banner extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'variants' => 'integer',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}

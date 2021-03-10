<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Stamm extends Model
{
    use HasFactory;

    protected $table = 'staemme';

    public $timestamps = false;

    public static function groupedByBezirk(): Collection
    {
        return static::pluck('name', 'id')
            ->groupBy(function ($name, $id) {
                // bezirk id
                return intdiv($id, 100) * 100;
            }, true)
            ->map(function ($troops, $bezirkId) {
                $staemme = [];
                $name = '';
                foreach ($troops as $id => $n) {
                    if ($id == $bezirkId) {
                        $name = $n;
                    } else {
                        $staemme[$id] = $n;
                    }
                }
                return compact('name', 'staemme');
            });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Troop extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function groupedByDistrict(): Collection
    {
        return static::pluck('name', 'id')
            ->groupBy(function ($name, $id) {
                // district id
                return intdiv($id, 100) * 100;
            }, true)
            ->map(function ($item, $districtId) {
                $troops = [];
                $name = '';
                foreach ($item as $id => $n) {
                    if ($id == $districtId) {
                        $name = $n;
                    } else {
                        $troops[$id] = $n;
                    }
                }
                return compact('name', 'troops');
            });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stufe extends Model
{
    use HasFactory;

    protected $table = 'stufen';

    public $timestamps = false;
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeamExport implements FromArray, WithHeadings
{
    private $teams;

    public function __construct(array $teams)
    {
        $this->teams = $teams;
    }

    public function headings(): array
    {
        return array_keys($this->teams[0]);
    }

    public function array(): array
    {
        return $this->teams;
    }
}

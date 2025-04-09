<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BalitaMultiSheetExport implements WithMultipleSheets
{
    protected $posyandus;

    public function __construct($posyandus)
    {
        $this->posyandus = $posyandus;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->posyandus as $posyandu) {
            $sheets[] = new BalitaTableExport(
                $posyandu->id,
                $posyandu->name,
                $posyandu->dusun->name
            );
        }
        return $sheets;
    }
}

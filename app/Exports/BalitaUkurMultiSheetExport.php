<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BalitaUkurMultiSheetExport implements WithMultipleSheets
{
    protected $periode;
    protected $posyandus;

    public function __construct($periode, $posyandus)
    {
        $this->periode = $periode;
        $this->posyandus = $posyandus;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->posyandus as $posyandu) {
            $sheets[] = new BalitaUkurTableExport(
                $posyandu->id,
                $this->periode,
                $posyandu->name,
                $posyandu->dusun->name
            );
        }
        return $sheets;
    }
}

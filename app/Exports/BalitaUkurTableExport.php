<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\BalitaUkur;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class BalitaUkurTableExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping
{
    protected $posyandu_id;
    protected $periode;
    protected $posyandu_name;
    protected $dusun_name;

    public function __construct($posyandu_id, $periode, $posyandu_name, $dusun_name)
    {
        $this->posyandu_id = $posyandu_id;
        $this->periode = $periode;
        $this->posyandu_name = $posyandu_name;
        $this->dusun_name = $dusun_name;
    }

    // BISA2
    public function collection()
    {
        // Memastikan bulan dan tahun dipecah dengan benar
        [$month, $year] = explode('.', $this->periode);

        // Memastikan tahun dalam format 4 digit
        if (strlen($year) == 2) {
            $year = '20' . $year;
        }

        // Query tanpa sorting
        $balitaUkur = BalitaUkur::query()
            ->with('balita.posyandu') // Eager load relasi balita dan posyandu
            ->when($this->posyandu_id, function ($q) {
                $q->whereHas('balita', function ($query) {
                    $query->where('posyandu_id', $this->posyandu_id);
                });
            })
            ->when($this->periode, function ($q) use ($month, $year) {
                $q->whereMonth('tgl_ukur', $month) // filter bulan
                    ->whereYear('tgl_ukur', $year); // filter tahun
            })
            ->get();

        // Sorting menggunakan sortBy setelah data diambil
        $sortedQuery = $balitaUkur->sortBy(function ($item) {
            return $item->balita->name; // Sort by name of balita
        });

        return $sortedQuery;
    }


    public function headings(): array
    {
        return [
            ['Laporan Pengukuran Balita Desa Selorejo'],
            ["Posyandu / Posyandu: {$this->posyandu_name} / {$this->dusun_name}"],
            ["Bulan: {$this->periode}"],
            [],
            [
                'No',
                'Nama',
                'NIK',
                'Tgl Ukur',
                'Umur Ukur',
                'BB (kg)',
                'TB (cm)',
                'LK (cm)',
                'Cara Ukur',
                'Status BB Naik',
                'BB / Umur',
                '',
                'TB / Umur',
                '',
                'BB / TB',
                '',
                'IMT / Umur',
                '',
                'LK / Umur',
                '',
                'Posyandu',
                'BPJS',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Status',
                'ZScore',
                'Status',
                'ZScore',
                'Status',
                'ZScore',
                'Status',
                'ZScore',
                'Status',
                'ZScore',
                '',
                ''
            ]
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function map($balitaUkur): array
    {

        return [
            '', // No (diisi otomatis di Excel)
            $balitaUkur->balita->name,
            $balitaUkur->balita->nik,
            Carbon::parse($balitaUkur->tgl_ukur)->format('d-m-Y'),
            $balitaUkur->umur_ukur,
            $balitaUkur->bb,
            $balitaUkur->tb,
            $balitaUkur->lk ?? '-',
            $balitaUkur->cara_ukur,
            $balitaUkur->status_bb_naik,
            $balitaUkur->status_bb_u,
            $balitaUkur->zscore_bb_u,
            $balitaUkur->status_tb_u,
            $balitaUkur->zscore_tb_u,
            $balitaUkur->status_bb_tb,
            $balitaUkur->zscore_bb_tb,
            $balitaUkur->status_imt_u,
            $balitaUkur->zscore_imt_u,
            $balitaUkur->status_lk_u ?? '-',
            $balitaUkur->zscore_lk_u ?? '-',
            $balitaUkur->balita->posyandu->name,
            $balitaUkur->balita->bpjs,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for title and header
        $sheet->mergeCells('A1:V1'); // Title
        $sheet->mergeCells('A2:V2'); // Posyandu
        $sheet->mergeCells('A3:V3'); // Bulan
        $sheet->mergeCells('K5:L5'); // BB/Umur
        $sheet->mergeCells('M5:N5'); // TB/Umur
        $sheet->mergeCells('O5:P5'); // BB/TB
        $sheet->mergeCells('Q5:R5'); // IMT/Umur
        $sheet->mergeCells('S5:T5'); // LK/Umur

        // Style for title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true);

        // Center alignment
        $sheet->getStyle('A5:V6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:V6')->getAlignment()->setVertical('center');

        // Bold headings
        $sheet->getStyle('A5:V6')->getFont()->setBold(true);

        // Add borders
        $sheet->getStyle('A5:V6')->getBorders()->getAllBorders()->setBorderStyle('thin');
    }
}

<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\BalitaUkur;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Barryvdh\Debugbar\Facades\Debugbar;

class BalitaUkurTableExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping,  WithTitle
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

    public function collection()
    {
        [$month, $year] = explode('.', $this->periode);
        $year = '20' . $year;

        $balitaQ = BalitaUkur::query()
            ->with(['balita.posyandu']) // Eager load relasi balita dan posyandu
            ->when($this->posyandu_id, function ($query) {
                $query->whereHas('balita', function ($q) {
                    $q->where('posyandu_id', $this->posyandu_id);
                });
            })
            ->whereMonth('tgl_ukur', $month)
            ->whereYear('tgl_ukur', $year)
            // ->orderBy('tgl_ukur')
            ->get();
        $balitaQuery = $balitaQ->sortBy(function ($item) {
            return $item->balita->name; // Urutkan berdasarkan nama balita
        });

        return $balitaQuery;
    }

    public function headings(): array
    {
        // Header sudah sesuai dengan kebutuhan
        [$bulan, $tahun] = explode('.', $this->periode);
        $tahun = '20' . $tahun;

        return [
            ['DAFTAR PENGUKURAN BALITA DESA SELOREJO'],
            ["Posyandu {$this->posyandu_name} atau Dusun {$this->dusun_name}"],
            ["Bulan {$bulan} - {$tahun}"],
            [],
            [
                'No',
                'Nama',
                'NIK',
                'Tanggal Ukur',
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
            '',
            $balitaUkur->balita->name,
            " " . $balitaUkur->balita->nik,
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
        // Atur formula otomatis untuk kolom No
        $highestRow = $sheet->getHighestRow();

        for ($row = 7; $row <= $highestRow; $row++) {
            $sheet->setCellValue("A{$row}", "=ROW()-6"); // Penomoran mulai dari baris 7
        }


        // Merge cells for title and header
        $sheet->mergeCells('A1:V1'); // Title
        $sheet->mergeCells('A2:V2'); // Posyandu
        $sheet->mergeCells('A3:V3'); // Bulan
        $sheet->mergeCells('K5:L5'); // BB/Umur
        $sheet->mergeCells('M5:N5'); // TB/Umur
        $sheet->mergeCells('O5:P5'); // BB/TB
        $sheet->mergeCells('Q5:R5'); // IMT/Umur
        $sheet->mergeCells('S5:T5'); // LK/Umur

        // Merge kolom
        $sheet->mergeCells('A5:A6');
        $sheet->mergeCells('B5:B6');
        $sheet->mergeCells('C5:C6');
        $sheet->mergeCells('D5:D6');
        $sheet->mergeCells('E5:E6');
        $sheet->mergeCells('F5:F6');
        $sheet->mergeCells('G5:G6');
        $sheet->mergeCells('H5:H6');
        $sheet->mergeCells('I5:I6');
        $sheet->mergeCells('J5:J6');
        $sheet->mergeCells('U5:U6');
        $sheet->mergeCells('V5:V6');

        // Style for title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12);
        $sheet->getStyle('A3')->getFont()->setSize(12);

        $lastRow = $sheet->getHighestRow();

        // Set font size to 12 for the entire sheet
        $sheet->getStyle("A5:V{$lastRow}")->getFont()->setSize(12);

        // Center alignment for header
        $sheet->getStyle('A5:V6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:V6')->getAlignment()->setVertical('center');

        // Bold headings
        $sheet->getStyle('A5:V6')->getFont()->setBold(true);

        // Add borders to header
        $sheet->getStyle('A5:V6')->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Add borders to body (from row 7 to the last row)
        // Determine the last row of the sheet
        $sheet->getStyle("A7:V{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Set cell height to 20 pixels
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Auto-size all columns
        foreach (range('A', 'V') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Center Vertical for all records
        $sheet->getStyle('A1:V' . $sheet->getHighestRow())->getAlignment()->setVertical('center');

        // Alignment for Body (Left for columns B, C, E; Center for others)
        // Kolom B, C, E: Left Align
        $sheet->getStyle('B7:B' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('C7:C' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('E7:E' . $lastRow)->getAlignment()->setHorizontal('left');

        // Kolom D, F sampai V: Center Align
        $sheet->getStyle('D7:D' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F7:V' . $lastRow)->getAlignment()->setHorizontal('center');
    }

    public function title(): string
    {
        return $this->posyandu_name; // Nama Posyandu menjadi judul sheet
    }
}

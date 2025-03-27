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
            ->whereNot('umur_ukur', '0 Bulan')
            // ->orderBy('tgl_ukur')
            ->get();
        $balitaQuery = $balitaQ->sortBy(function ($item) {
            return $item->balita->name; // Urutkan berdasarkan nama balita
        });

        // // Menambahkan nomor urut pada setiap item
        // $balitaQuery->each(function ($item, $index) {
        //     // Menambahkan properti nomor urut pada setiap item
        //     $item->nomor_urut = $index + 1; // Mulai dari 1
        // });

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
                'L/P',
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

    private $index = 0; // Inisialisasi index
    public function map($balitaUkur): array
    {



        $this->index++; // Tambahkan 1 setiap pemanggilan map()

        return [

            $this->index,
            $balitaUkur->balita->name,
            " " . $balitaUkur->balita->nik,
            $balitaUkur->balita->gender,
            Carbon::parse($balitaUkur->tgl_ukur)->format('d-m-Y'),
            $balitaUkur->umur_ukur,
            $balitaUkur->bb,
            $balitaUkur->tb,
            $balitaUkur->lk ?? '-',
            $balitaUkur->cara_ukur,
            // $balitaUkur->status_bb_naik,
            $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb),
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
        // // Atur formula otomatis untuk kolom No
        // $highestRow = $sheet->getHighestRow();

        // for ($row = 7; $row <= $highestRow; $row++) {
        //     $sheet->setCellValue("A{$row}", "=ROW()-6"); // Penomoran mulai dari baris 7
        // }


        // Merge cells for title and header
        $sheet->mergeCells('A1:V1'); // Title
        $sheet->mergeCells('A2:V2'); // Posyandu
        $sheet->mergeCells('A3:V3'); // Bulan

        $sheet->mergeCells('L5:M5'); // BB/Umur
        $sheet->mergeCells('N5:O5'); // TB/Umur
        $sheet->mergeCells('P5:Q5'); // BB/TB
        $sheet->mergeCells('R5:S5'); // IMT/Umur
        $sheet->mergeCells('T5:U5'); // LK/Umur

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
        $sheet->mergeCells('K5:K6');
        $sheet->mergeCells('V5:V6');
        $sheet->mergeCells('W5:W6');

        // Style for title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12);
        $sheet->getStyle('A3')->getFont()->setSize(12);

        $lastRow = $sheet->getHighestRow();

        // Set font size to 12 for the entire sheet
        $sheet->getStyle("A5:W{$lastRow}")->getFont()->setSize(12);

        // Center alignment for header
        $sheet->getStyle('A5:W6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:W6')->getAlignment()->setVertical('center');

        // Bold headings
        $sheet->getStyle('A5:W6')->getFont()->setBold(true);

        // Add borders to header
        $sheet->getStyle('A5:W6')->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Add borders to body (from row 7 to the last row)
        // Determine the last row of the sheet
        $sheet->getStyle("A7:W{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Set cell height to 20 pixels
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Auto-size all columns
        foreach (range('A', 'W') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Center Vertical for all records
        $sheet->getStyle('A1:W' . $sheet->getHighestRow())->getAlignment()->setVertical('center');

        // Alignment for Body (Left for columns B, C, E; Center for others)
        // Kolom B, C, E: Left Align
        $sheet->getStyle('B7:B' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('C7:C' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('F7:F' . $lastRow)->getAlignment()->setHorizontal('left');

        // Kolom A, D, F sampai V: Center Align
        $sheet->getStyle('A7:A' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D7:D' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E7:E' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G7:W' . $lastRow)->getAlignment()->setHorizontal('center');
    }

    public function title(): string
    {
        return $this->posyandu_name; // Nama Posyandu menjadi judul sheet
    }

    public function statusBBNaik($balita_id, $tgl_ukur, $bb)
    {

        // Ambil semua data sebelumnya untuk balita yang sama
        $allPrevious = BalitaUkur::where('balita_id', $balita_id)
            ->where('tgl_ukur', '<', $tgl_ukur)
            ->orderBy('tgl_ukur', 'desc')
            ->get();


        // Ambil data pertama dan kedua dari collection
        $previous = $allPrevious->first(); // Data pertama
        $previousKedua = $allPrevious->skip(1)->first(); // Data kedua

        // Jika tidak ada data sebelumnya
        if (!$previous) {
            return 'L';
        } else if (!$previousKedua) {
            return 'B';
        }
        $diffInDays = Carbon::parse($tgl_ukur)->diffInDays(Carbon::parse($previous->tgl_ukur));

        // Versi Baru Pengkondisian Status BB Naik
        return match (true) {
            $diffInDays > 35 => 'O',
            ($bb <= $previous->bb && $previous->bb <= $previousKedua->bb) => '2T',
            ($bb <= $previous->bb) => 'T',
            default => 'N'
        };

        // Versi Lama Pengkondisian Status BB Naik
        // if ($diffInDays > 35) {
        //     return 'O';
        // } else if ($bb < $previous->bb && $previous->bb < $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb < $previous->bb && $previous->bb == $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb && $previous->bb == $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb && $previous->bb < $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb) {
        //     return 'T'; // Berat badan tidak naik
        // } else if ($bb < $previous->bb) {
        //     return 'T'; // Berat badan tidak naik
        // } else {
        //     return 'N'; // Berat badan naik
        // }


    }
}

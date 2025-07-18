<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Balita;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facades\Debugbar;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class BalitaTableExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping,  WithTitle
{
    protected $posyandu_id;
    protected $posyandu_name;
    protected $dusun_name;

    public function __construct($posyandu_id, $posyandu_name, $dusun_name)
    {
        $this->posyandu_id = $posyandu_id;
        $this->posyandu_name = $posyandu_name;
        $this->dusun_name = $dusun_name;
    }

    public function collection()
    {



        $balitaQuery = Balita::aktif()->with(['orangtua.dusun', 'orangtua.rt'])->where('posyandu_id', $this->posyandu_id)->orderBy('name', 'asc')->get();

        // // Menambahkan nomor urut pada setiap item
        // $balitaQuery->each(function ($item, $index) {
        //     // Menambahkan properti nomor urut pada setiap item
        //     $item->nomor_urut = $index + 1; // Mulai dari 1
        // });

        return $balitaQuery;
    }

    public function headings(): array
    {
        $tanggal = Carbon::now()->format('d-m-Y');

        return [
            ['DAFTAR BALITA DESA SELOREJO'],
            ["Posyandu {$this->posyandu_name} atau Dusun {$this->dusun_name}"],
            ["Per Tanggal {$tanggal} "],
            [],
            [
                'No',
                'Nama',
                'NIK',
                'L/P',
                'Tanggal Lahir',
                'Nama Ibu',
                'Anak Ke',
                'BPJS Balita',
                'Alamat',
                'RT/RW',
                'Desa',
                'Kecamatan',
                'Kabupaten',
                'Provinsi',
            ],

        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    private $index = 0; // Inisialisasi index
    public function map($balita): array
    {



        $this->index++; // Tambahkan 1 setiap pemanggilan map()

        return [

            $this->index,
            $balita->name,
            " " . $balita->nik,
            $balita->gender,
            Carbon::parse($balita->tgl_lahir)->format('d-m-Y'),
            $balita->orangtua->name_ibu,
            $balita->family_order,
            $balita->bpjs,
            $balita->orangtua->dusun->name,
            $balita->orangtua->rt->rt . "/" . $balita->orangtua->dusun->rw,
            $balita->orangtua->desa,
            $balita->orangtua->kecamatan,
            $balita->orangtua->kabupaten,
            $balita->orangtua->provinsi,

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
        $sheet->mergeCells('A1:N1'); // Title
        $sheet->mergeCells('A2:N2'); // Posyandu
        $sheet->mergeCells('A3:N3'); // Bulan





        // Style for title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12);
        $sheet->getStyle('A3')->getFont()->setSize(12);

        $lastRow = $sheet->getHighestRow();

        // Set font size to 12 for the entire sheet
        $sheet->getStyle("A5:N{$lastRow}")->getFont()->setSize(12);

        // Center alignment for header
        $sheet->getStyle('A5:N5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:N5')->getAlignment()->setVertical('center');

        // Bold headings
        $sheet->getStyle('A5:N5')->getFont()->setBold(true);

        // Add borders to header
        $sheet->getStyle('A5:N5')->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Add borders to body (from row 7 to the last row)
        // Determine the last row of the sheet
        $sheet->getStyle("A6:N{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Set cell height to 20 pixels
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Auto-size all columns
        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Center Vertical for all records
        $sheet->getStyle('A1:N' . $sheet->getHighestRow())->getAlignment()->setVertical('center');

        // Alignment for Body (Left for columns B, C, E; Center for others)
        // Kolom B, C, E: Left Align
        $sheet->getStyle('B6:B' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('C6:C' . $lastRow)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('F6:F' . $lastRow)->getAlignment()->setHorizontal('left');

        // Kolom A, D, F sampai V: Center Align
        $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D6:D' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E6:E' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G6:G' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G6:G' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H6:H' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I6:I' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J6:J' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('K6:K' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('L6:L' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('M6:M' . $lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('N6:N' . $lastRow)->getAlignment()->setHorizontal('center');
    }

    public function title(): string
    {
        return $this->posyandu_name; // Nama Posyandu menjadi judul sheet
    }
}

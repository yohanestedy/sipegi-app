<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalitaUkur extends Model
{
    use HasFactory;
    protected $table = 'balita_ukur';
    protected $guarded = [];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }


    protected $appends = ['tgl_ukur_display'];
    public function getTglUkurDisplayAttribute()
    {
        return Carbon::parse($this->tgl_ukur)->translatedFormat('d F Y');
    }
    public function getTglUkurAngkaAttribute()
    {
        return Carbon::parse($this->tgl_ukur)->format('d-m-Y');
    }



    // Status BB Naik(N)/Turun(T)/Lewat Sekali pengukuran
    // public function getStatusBbNaikAttribute()
    // {


    //     // Ambil semua data sebelumnya untuk balita yang sama
    //     $allPrevious = self::where('balita_id', $this->balita_id)
    //         ->where('tgl_ukur', '<', $this->tgl_ukur)
    //         ->orderBy('tgl_ukur', 'desc')
    //         ->get();


    //     // Ambil data pertama dan kedua dari collection
    //     $previous = $allPrevious->first(); // Data pertama
    //     $previousKedua = $allPrevious->skip(1)->first(); // Data kedua


    //     // return $previous_kedua;
    //     // Jika tidak ada data sebelumnya
    //     if (!$previous) {
    //         return 'L';
    //     } else if (!$previousKedua) {
    //         return 'B';
    //     }

    //     $diffInDays = Carbon::parse($this->tgl_ukur)->diffInDays(Carbon::parse($previous->tgl_ukur));



    //     if ($diffInDays > 35) {
    //         return 'O';
    //     } else if ($this->bb < $previous->bb && $previous->bb < $previousKedua->bb) {
    //         return '2T'; // Berat badan turun dua kali berturut-turut
    //     } else if ($this->bb == $previous->bb) {
    //         return '2T'; // Berat badan sama dengan bulan lalu
    //     } else if ($this->bb < $previous->bb) {
    //         return 'T'; // Berat badan turun sekali
    //     } else {
    //         return 'N'; // Berat badan naik
    //     }
    // }

    // public function getStatusBbNAttribute()
    // {
    //     return $this->statusBBNaik($this->balita_id, $this->tgl_ukur, $this->bb);
    // }

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

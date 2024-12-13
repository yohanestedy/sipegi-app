<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalitaUkurNonaktif extends Model
{
    use HasFactory;
    protected $table = 'balita_ukur_nonaktif';
    protected $guarded = [];

    public function balitaNonaktif()
    {
        return $this->belongsTo(BalitaNonaktif::class);
    }


    protected $appends = ['tgl_ukur_display'];
    public function getTglUkurDisplayAttribute()
    {
        return Carbon::parse($this->tgl_ukur)->translatedFormat('d F Y');
    }

    // Status BB Naik(N)/Turun(T)/Lewat Sekali pengukuran
    public function getStatusBbNaikAttribute()
    {


        // Ambil semua data sebelumnya untuk balita yang sama
        $allPrevious = self::where('balita_id', $this->balita_id)
            ->where('tgl_ukur', '<', $this->tgl_ukur)
            ->orderBy('tgl_ukur', 'desc')
            ->get();


        // Ambil data pertama dan kedua dari collection
        $previous = $allPrevious->first(); // Data pertama
        $previousKedua = $allPrevious->skip(1)->first(); // Data kedua


        // return $previous_kedua;
        // Jika tidak ada data sebelumnya
        if (!$previous) {
            return 'L';
        } else if (!$previousKedua) {
            return 'B';
        }

        $diffInDays = Carbon::parse($this->tgl_ukur)->diffInDays(Carbon::parse($previous->tgl_ukur));



        if ($diffInDays > 35) {
            return 'O';
        } else if ($this->bb < $previous->bb) {
            return 'T';
        } else if ($this->bb == $previous->bb) {
            return '2T';
        } else {
            return 'N';
        }
    }
}

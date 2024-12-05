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
    public function balitaLulus()
    {
        return $this->belongsTo(BalitaLulus::class);
    }

    protected $appends = ['tgl_ukur_display', 'status_bb_naik'];
    public function getTglUkurDisplayAttribute()
    {
        return Carbon::parse($this->tgl_ukur)->translatedFormat('d F Y');
    }

    // Status BB Naik(N)/Turun(T)/Lewat Sekali pengukuran
    public function getStatusBbNaikAttribute()
    {


        // Ambil data tepat sebelum tanggal ukur saat ini
        $previous = self::where('balita_id', $this->balita_id) // Hanya untuk balita yang sama
            ->where('tgl_ukur', '<', $this->tgl_ukur) // Tanggal sebelum pengukuran saat ini
            ->orderBy('tgl_ukur', 'desc') // Urutkan dari yang terbaru
            ->first(); // Ambil data pertama (terdekat sebelum tanggal saat ini)

        $previous_kedua = self::where('balita_id', $this->balita_id) // Hanya untuk balita yang sama
            ->where('tgl_ukur', '<', $this->tgl_ukur) // Tanggal sebelum pengukuran saat ini
            ->orderBy('tgl_ukur', 'desc')
            ->skip(1) // Lewati data pertama
            ->take(1) // Ambil satu data berikutnya
            ->first();


        // return $previous_kedua;
        // Jika tidak ada data sebelumnya
        if (!$previous) {
            return 'L';
        } else if (!$previous_kedua) {
            return 'B';
        }

        $diffInDays = Carbon::parse($this->tgl_ukur)->diffInDays(Carbon::parse($previous->tgl_ukur));
        $diffInMonths = Carbon::parse($this->tgl_ukur)->diffInMonths(Carbon::parse($previous->tgl_ukur));


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

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalitaLulus extends Model
{
    use HasFactory;
    protected $table = 'balita_lulus';
    protected $guarded = [];

    public function balitaUkur()
    {
        return $this->hasMany(BalitaUkur::class);
    }

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class);
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    protected $appends = ['umur_hari', 'umur_bulan', 'umur_display', 'tgl_lahir_display', 'gender_display'];

    public function getUmurHariAttribute()
    {
        // Memastikan tanggal lahir tersedia
        if (!$this->tgl_lahir) {
            return null;
        }

        $tglLahir = Carbon::parse($this->tgl_lahir);
        $umurHari = $tglLahir->diffInDays(now());

        return $umurHari;
    }

    public function getUmurBulanAttribute()
    {
        // Memastikan tanggal lahir tersedia
        if (!$this->tgl_lahir) {
            return null;
        }

        // Menghitung selisih antara tanggal lahir dan tanggal saat ini dalam hari
        $tanggalLahir = Carbon::parse($this->tgl_lahir);
        $hariSelisih = $tanggalLahir->diffInDays(Carbon::now());

        // Menghitung umur dalam bulan penuh (1 bulan dihitung genap 30 hari)
        $umurBulan = intdiv($hariSelisih, 30);

        return $umurBulan;
    }



    public function getUmurDisplayAttribute()
    {
        $tglLahir = Carbon::parse($this->tgl_lahir);
        $umurHari = $tglLahir->diffInDays(now());
        $umurBulan = floor($umurHari / 30.4375);
        $tahun = floor($umurHari / 365.25);
        $bulan = $umurBulan % 12;
        $hari = round($umurHari - floor($umurHari / 30.4375) * 30.4375);

        if ($umurHari <= 730) {
            // Jika umur kurang dari atau sama dengan 730 hari (2 tahun)
            return "{$umurBulan} Bulan -  {$hari} Hari";
        } else {
            // Jika umur lebih dari 730 hari
            return "{$tahun} Tahun -  {$bulan} Bulan -  {$hari} Hari";
        }
    }

    // Mengembalikan tanggal lahir dalam format yang diinginkan
    public function getTglLahirDisplayAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->translatedFormat('d F Y');
    }

    // Mengembalikan gender dalam format yang diinginkan
    public function getGenderDisplayAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
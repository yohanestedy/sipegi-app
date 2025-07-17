<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Balita extends Model
{
    use HasFactory;
    protected $table = 'balita';
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

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNonaktif($query)
    {
        return $query->where('is_active', false);
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

        $tglLahir = Carbon::parse($this->tgl_lahir);
        $umurHari = $tglLahir->diffInDays(now());

        $umurBulan = ceil($umurHari / 30.4375);

        return $umurBulan;
    }



    public function getUmurDisplayAttribute()
    {
        $tglLahir = Carbon::parse($this->tgl_lahir);
        $umurHari = $tglLahir->diffInDays(now());
        // $umurBulan = floor($umurHari / 30);
        // $tahun = floor($umurBulan / 12);
        // $bulan = $umurBulan % 12;
        // $hari = $umurHari % 30;
        $umurBulan = floor($umurHari / 30.4375);

        $tahun = floor($umurHari / 365.25);
        $sisaHariSetelahTahun = $umurHari - $tahun * 365.25;
        // $bulan = $umurBulan % 12;
        $bulan = floor($sisaHariSetelahTahun / 30.4375);
        // $sisaHariSetelahBulan = $sisaHariSetelahTahun - $bulan * 30.4375;
        $hari = floor($umurHari - $umurBulan * 30.4375);








        if ($umurHari <= 730) {
            // Jika umur kurang dari atau sama dengan 730 hari (2 tahun)
            return "{$umurBulan} Bulan -  {$hari} Hari";
        } else {
            // Jika umur lebih dari 730 hari
            return "{$tahun} Tahun -  {$bulan} Bulan -  {$hari} Hari";
        }
    }

    // Mengembalikan tanggal lahir dalam format Huruf
    public function getTglLahirDisplayAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->translatedFormat('d F Y');
    }

    // Mengembalikan tanggal lahir dalam format Angka
    public function getTglLahirAngkaAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->format('d-m-Y');
    }

    public function getTglNonaktifAngkaAttribute()
    {
        return Carbon::parse($this->tgl_nonaktif)->format('d-m-Y');
    }

    // Mengembalikan gender dalam format yang diinginkan
    public function getGenderDisplayAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}

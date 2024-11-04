<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $appends = ['umur_display'];

    public function getUmurDisplayAttribute()
    {
        $tglLahir = \Carbon\Carbon::parse($this->tgl_lahir);
        $umurHari = $tglLahir->diffInDays(now());
        $umurBulan = floor($umurHari / 30);

        if ($umurBulan < 24) {
            return "{$umurBulan} bulan";
        } else {
            $tahun = floor($umurBulan / 12);
            $bulan = $umurBulan % 12;
            return "{$tahun} tahun {$bulan} bulan";
        }
    }
}

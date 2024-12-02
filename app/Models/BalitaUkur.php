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

    protected $appends = ['tgl_ukur_display'];
    public function getTglUkurDisplayAttribute()
    {
        return Carbon::parse($this->tgl_ukur)->translatedFormat('d F Y');
    }
}

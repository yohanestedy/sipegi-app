<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $table = 'orangtua';
    protected $guarded = [];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function balita()
    {
        return $this->hasMany(Balita::class);
    }
    public function balitaLulus()
    {
        return $this->hasMany(BalitaLulus::class);
    }
}

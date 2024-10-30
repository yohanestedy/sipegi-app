<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalitaUkur extends Model
{
    use HasFactory;
    protected $table = 'balita_ukur';
    protected $guarded = [];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }
}

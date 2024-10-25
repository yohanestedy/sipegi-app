<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;
    protected $table = 'rt';
    protected $guarded = [];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function orangtua()
    {
        return $this->hasMany(Orangtua::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;
    protected $table = 'posyandu';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function balita()
    {
        return $this->hasMany(Balita::class);
    }
    public function balitaLulus()
    {
        return $this->hasMany(BalitaLulus::class);
    }
    public function dusun()
    {
        return $this->hasOne(Dusun::class, 'id', 'id');
    }
}

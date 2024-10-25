<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    use HasFactory;
    protected $table = 'dusun';
    protected $guarded = [];

    public function rt()
    {
        return $this->hasMany(Rt::class);
    }
    public function orangtua()
    {
        return $this->hasMany(Orangtua::class);
    }
}

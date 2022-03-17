<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    public $timestamps = false;
    protected $fillable = ['nama_kelas', 'kelompok'];
}

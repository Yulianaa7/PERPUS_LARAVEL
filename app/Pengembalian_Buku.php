<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengembalian_Buku extends Model
{
    protected $table = 'pengembalian_buku';
    public $timestamps = false;
    protected $fillable = ['id_peminjaman_buku', 'tanggal_pengembalian', 'denda'];
}

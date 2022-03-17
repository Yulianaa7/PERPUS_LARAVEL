<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman_Buku extends Model
{
    protected $table = 'peminjaman_buku';
    public $timestamps = false;
    protected $fillable = ['id_siswa', 'tanggal_pinjam', 'tanggal_kembali'];
}

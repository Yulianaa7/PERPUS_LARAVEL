<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Peminjaman_Buku extends Model
{
    protected $table = 'detail_peminjaman_buku';
    public $timestamps = false;
    protected $fillable = ['id_peminjaman_buku', 'id_buku', 'qty'];
}

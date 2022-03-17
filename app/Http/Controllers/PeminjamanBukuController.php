<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman_Buku;
use Illuminate\Support\Facades\Validator;

class PeminjamanBukuController extends Controller
{
    public function show(){
        $data_peminjamanbuku = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', 'peminjaman_buku.id_siswa')->get();
        return Response()->json($data_peminjamanbuku);
    }

    public function detail($id)
    {
        if(Peminjaman_Buku::where('id_peminjaman_buku', $id)->exists()) {
            $data_peminjamanbuku = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', 'peminjaman_buku.id_siswa')->where('peminjaman_buku.id_peminjaman_buku', '=', $id)->get();
            return Response()->json($data_peminjamanbuku);
        }
        else {return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_siswa' => 'required',
                'tanggal_pinjam' => 'required',
                'tanggal_kembali' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Peminjaman_Buku::create([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);
        if($simpan)
        {
            return Response()->json(['status' => 1]);
        }
        else
        {
            return Response()->json(['status' => 0]);
        }
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [   
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
        ]);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = Peminjaman_Buku::where('id_peminjaman_buku', $id)->update([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }else{
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = Peminjaman_Buku::where('id_peminjaman_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

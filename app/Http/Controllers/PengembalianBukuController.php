<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengembalian_Buku;
use App\Peminjaman_Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PengembalianBukuController extends Controller
{
    //create data
    public function mengembalikanBuku(Request $req){
        $validator = Validator::make($req->all(), [
            'id_peminjaman_buku' => 'required'
        ]);
        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $cek_kembali = Pengembalian_Buku::where('id_peminjaman_buku', $req->id_peminjaman_buku);
        if($cek_kembali->count() == 0){
            $dt_kembali = Peminjaman_Buku::where('id_peminjaman_buku', $req->id_peminjaman_buku)->first();
            $tanggal_sekarang = Carbon::now()->format('Y-m-d');
            $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
            $dendaperhari = 1500;
            if(strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)) {
                $jumlah_hari = $tanggal_kembali -> diff ($tanggal_sekarang)->days;
                $denda = $jumlah_hari*$dendaperhari;
            } else{
                $denda = 0;
            }

            $save = Pengembalian_Buku::create([
                'id_peminjaman_buku' => $req->id_peminjaman_buku,
                'tanggal_pengembalian' => $tanggal_sekarang,
                'denda' => $denda,
            ]);
            if($save){
                $data['status'] = 1;
                $data['message'] = 'Berhasil Dikembalikan';
            } else {
                $data['status'] = 0;
                $data['message'] = 'Pengembalian gagal';
            }
        } else {
            $data = ['status' => 0, 'message'=>'Sudah Pernah Dikembalikan'];
        }
        return response()->json($data);
    }
    
    public function show(){
        $data_pengembalianbuku = Pengembalian_Buku::join('peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', 'pengembalian_buku.id_peminjaman_buku')->get();
        return Response()->json($data_pengembalianbuku);
    }

    public function detail($id)
    {
        if(Pengembalian_Buku::where('id_pengembalian_buku', $id)->exists()) {
            $data_pengembalianbuku = Pengembalian_Buku::join('peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', 'pengembalian_buku.id_peminjaman_buku')->where('pengembalian_buku.id_pengembalian_buku', '=', $id)->get();
            return Response()->json($data_pengembalianbuku);
        }
        else {return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }

    //public function store(Request $request)
    //{
    //    $validator=Validator::make($request->all(),
    //        [
    //            'tanggal_pengembalian' => 'required',
    //            'denda' => 'required',
    //            'id_peminjaman_buku' => 'required'
    //        ]
    //    );
    //    if($validator->fails()) {
    //        return Response()->json($validator->errors());
    //    }

    //    $simpan = Pengembalian_Buku::create([
    //        'tanggal_pengembalian' => $request->tanggal_pengembalian,
    //        'denda' => $request->denda,
    //        'id_peminjaman_buku' => $request->id_peminjaman_buku
    //    ]);
    //    if($simpan)
    //    {
    //        return Response()->json(['status' => 1]);
    //    }
    //    else
    //    {
    //        return Response()->json(['status' => 0]);
    //    }
    //}

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [   
            'tanggal_pengembalian' => 'required',
            'denda' => 'required',
            'id_peminjaman_buku' => 'required'
        ]);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = Pengembalian_Buku::where('id_pengembalian_buku', $id)->update([
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'denda' => $request->denda,
            'id_peminjaman_buku' => $request->id_peminjaman_buku
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }else{
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = Pengembalian_Buku::where('id_pengembalian_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

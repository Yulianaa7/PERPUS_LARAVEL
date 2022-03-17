<?php

namespace App\Http\Controllers;

use App\Detail_Peminjaman_Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; //agar bisa menggunakan query

class Detail_PeminjamanBukuController extends Controller
{
    public function show(){
        $data = DB::table('detail_peminjaman_buku') 
        -> join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
        ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku')
        ->select('peminjaman_buku.id_peminjaman_buku', 'peminjaman_buku.tanggal_pinjam', 'buku.nama_buku', 'detail_peminjaman_buku.qty')->get();

        return Response()->json($data);
    }

    public function detail($id)
    {
        if(Detail_Peminjaman_Buku::where('id_detail', $id)->exists()) {
        $data = DB::table('detail_peminjaman_buku')
           ->join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
           ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku')
           ->select('peminjaman_buku.id_peminjaman_buku', 'peminjaman_buku.tanggal_pinjam', 'buku.nama_buku', 'detail_peminjaman_buku.qty')
           ->where('detail_peminjaman_buku.id_detail', '=', $id)
           ->get();
        return Response()->json($data);
        }
        else {
            return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_peminjaman_buku' => 'required',
                'id_buku' => 'required',
                'qty' => 'required',
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Detail_Peminjaman_Buku::create([
                'id_peminjaman_buku' => $request->id_peminjaman_buku,
                'id_buku' => $request->id_buku,
                'qty' => $request->qty
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
            'id_peminjaman_buku' => 'required',
            'id_buku' => 'required',
            'qty' => 'required',
        ]);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $ubah = Detail_Peminjaman_Buku::where('id_detail', $id)->update([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'id_buku' => $request->id_buku,
            'qty' => $request->qty
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }else{
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = Detail_Peminjaman_Buku::where('id_detail', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

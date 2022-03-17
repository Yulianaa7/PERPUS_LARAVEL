<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; //agar password nya tidak terlihat

class KelasController extends Controller
{
    public function show(){
        return Kelas::all();
    }

    public function detail($id)
    {
        if(Kelas::where('id_kelas', $id)->exists()) {
            $data = DB::table('kelas')->where('kelas.id_kelas', '=', $id)->get();
            return Response()->json($data);
        }
    }
    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_kelas' => 'required',
                'kelompok' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kelompok' => $request->kelompok
        ]);
        if($simpan) {
            return Response()->json(['status'=>1]);
        }
        else {
            return Response()->json(['status'=>0]);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama_kelas' => 'required',
            'kelompok' => 'required'
        ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Kelas::where('id_kelas', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'kelompok' => $request->kelompok
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = Kelas::where('id_kelas', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

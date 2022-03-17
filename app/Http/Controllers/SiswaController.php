<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; //agar password nya tidak terlihat

class SiswaController extends Controller
{
    public function show(){
        $data_siswa = Siswa::join('kelas', 'kelas.id_kelas', 'siswa.id_kelas')->get();
        return Response()->json($data_siswa);
    }

    public function detail($id)
    {
        if(Siswa::where('id_siswa', $id)->exists()) {
            $data = DB::table('siswa')->where('siswa.id_siswa', '=', $id)->get();
            return Response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_siswa' => 'required',
                'tanggal_lahir' => 'required',
                'gender' => 'required',
                'alamat' => 'required',
                'id_kelas' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
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

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
        ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Siswa::where('id_siswa', $id)->update([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
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
        $hapus = Siswa::where('id_siswa', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

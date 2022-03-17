<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::group(['middleware' => ['jwt.verify']], function ()
{
    Route::get('/login_check','UserController@getAuthenticatedUser');
    Route::group(['middleware' => ['api.superadmin']], function(){
        Route::delete('/buku/{id_buku}', 'BukuController@destroy');
        Route::delete('/siswa/{id_siswa}', 'SiswaController@destroy');
        Route::delete('/kelas/{id_kelas}', 'KelasController@destroy');
        Route::delete('/peminjaman_buku/{id_peminjaman_buku}', 'PeminjamanBukuController@destroy');
        Route::delete('/pengembalian_buku/{id_pengembalian_buku}', 'PengembalianBukuController@destroy');
        Route::delete('/detail_peminjaman_buku/{id_detail}', 'Detail_PeminjamanBukuController@destroy');
    });
    Route::group(['middleware' => ['api.admin']], function(){
        Route::put('/buku/{id_buku}', 'BukuController@update');
        Route::post('/buku', 'BukuController@store');

        Route::put('/siswa/{id_siswa}', 'SiswaController@update');
        Route::post('/siswa', 'SiswaController@store');

        Route::put('/kelas/{id_kelas}', 'KelasController@update');
        Route::post('/kelas', 'KelasController@store');

        Route::put('/peminjaman_buku/{id_peminjaman_buku}', 'PeminjamanBukuController@update');
        Route::post('/peminjaman_buku', 'PeminjamanBukuController@store');

        Route::put('/pengembalian_buku/{id_pengembalian_buku}', 'PengembalianBukuController@update');
        Route::post('/pengembalian_buku', 'PengembalianBukuController@mengembalikanBuku');

        Route::put('/detail_peminjaman_buku/{id_detail}', 'Detail_PeminjamanBukuController@update');
        Route::post('/detail_peminjaman_buku', 'Detail_PeminjamanBukuController@store');
    });
Route::get('/buku', 'BukuController@show');
Route::get('/buku/{id_buku}', 'BukuController@detail');
//Route::put('/buku/{id_buku}', 'BukuController@update');
//Route::post('/buku', 'BukuController@store');
//Route::delete('/buku/{id_buku}', 'BukuController@destroy');

Route::get('/siswa', 'SiswaController@show');
Route::get('/siswa/{id_siswa}', 'SiswaController@detail');
//Route::put('/siswa/{id_siswa}', 'SiswaController@update');
//Route::post('/siswa', 'SiswaController@store');
//Route::delete('/siswa/{id_siswa}', 'SiswaController@destroy');

Route::get('/kelas', 'KelasController@show');
Route::get('/kelas/{id_kelas}', 'KelasController@detail');
//Route::put('/kelas/{id_kelas}', 'KelasController@update');
//Route::post('/kelas', 'KelasController@store');
//Route::delete('/kelas/{id_kelas}', 'KelasController@destroy');

Route::get('/peminjaman_buku', 'PeminjamanBukuController@show');
Route::get('/peminjaman_buku/{id_peminjaman_buku}', 'PeminjamanBukuController@detail');
//Route::put('/peminjaman_buku/{id_peminjaman_buku}', 'PeminjamanBukuController@update');
//Route::post('/peminjaman_buku', 'PeminjamanBukuController@store');
//Route::delete('/peminjaman_buku/{id_peminjaman_buku}', 'PeminjamanBukuController@destroy');

Route::get('/pengembalian_buku', 'PengembalianBukuController@show');
Route::get('/pengembalian_buku/{id_pengembalian_buku}', 'PengembalianBukuController@detail');
//Route::put('/pengembalian_buku/{id_pengembalian_buku}', 'PengembalianBukuController@update');
//Route::post('/pengembalian_buku', 'PengembalianBukuController@store');
//Route::delete('/pengembalian_buku/{id_pengembalian_buku}', 'PengembalianBukuController@destroy');

Route::get('/detail_peminjaman_buku', 'Detail_PeminjamanBukuController@show');
Route::get('/detail_peminjaman_buku/{id_detail}', 'Detail_PeminjamanBukuController@detail');
//Route::put('/detail_peminjaman_buku/{id_detail}', 'Detail_PeminjamanBukuController@update');
//Route::post('/detail_peminjaman_buku', 'Detail_PeminjamanBukuController@store');
//Route::delete('/detail_peminjaman_buku/{id_detail}', 'Detail_PeminjamanBukuController@destroy');
});
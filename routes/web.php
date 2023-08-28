<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.masuk');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('karyawan', 'KaryawanController@karyawan')->name('karyawan');
Route::post('tambah_karyawan', 'KaryawanController@tambah_karyawan')->name('karyawan.tambah');
Route::post('ubah_karyawan', 'KaryawanController@ubah_karyawan')->name('karyawan.ubah');
Route::get('get_ubah_karyawan/{id}', 'KaryawanController@get_ubah_karyawan')->name('karyawan.getubah');
Route::get('hapus_karyawan/{id}', 'KaryawanController@hapus_karyawan')->name('karyawan.hapus');

Route::get('jabatan', 'JabatanController@jabatan')->name('jabatan');
Route::post('tambah_jabatan', 'JabatanController@tambah_jabatan')->name('jabatan.tambah');
Route::post('ubah_jabatan', 'JabatanController@ubah_jabatan')->name('jabatan.ubah');
Route::get('get_ubah_jabatan/{id}', 'JabatanController@get_ubah_jabatan')->name('jabatan.getubah');
Route::get('hapus_jabatan/{id}', 'JabatanController@hapus_jabatan')->name('jabatan.hapus');

Route::get('departemen', 'DepartemenController@departemen')->name('departemen');
Route::post('tambah_departemen', 'DepartemenController@tambah_departemen')->name('departemen.tambah');
Route::post('ubah_departemen', 'DepartemenController@ubah_departemen')->name('departemen.ubah');
Route::get('get_ubah_departemen/{id}', 'DepartemenController@get_ubah_departemen')->name('departemen.getubah');
Route::get('hapus_departemen/{id}', 'DepartemenController@hapus_departemen')->name('departemen.hapus');

Route::get('absensi', 'AbsensiController@absensi')->name('absensi');
Route::get('absensis', 'AbsensiController@absensiWithDate')->name('absensi.with.date');
Route::post('tambah_absensi', 'AbsensiController@tambah_absensi')->name('absensi.tambah');
Route::post('ubah_absensi', 'AbsensiController@ubah_absensi')->name('absensi.ubah');
Route::get('get_log_absensi/{day}', 'AbsensiController@get_log_absensi')->name('absensi.log');
Route::get('get_absen_absensi/{day}', 'AbsensiController@get_absen_absensi')->name('absensi.absen');
Route::get('get_ubah_absensi/{id}', 'AbsensiController@get_ubah_absensi')->name('absensi.getubah');
Route::get('hapus_absensi/{id}', 'AbsensiController@hapus_absensi')->name('absensi.hapus');


Route::get('pengajuanCuti', 'PengajuanCutiController@pengajuanCutiWithDate')->name('pengajuanCuti');
Route::get('pengajuanCutis', 'PengajuanCutiController@pengajuanCutiWithDate')->name('pengajuanCuti.with.date');
Route::post('tambah_pengajuanCuti', 'PengajuanCutiController@tambah_pengajuanCuti')->name('pengajuanCuti.tambah');
Route::post('ubah_pengajuanCuti', 'PengajuanCutiController@ubah_pengajuanCuti')->name('pengajuanCuti.ubah');
Route::get('get_ubah_pengajuanCuti/{id}', 'PengajuanCutiController@get_ubah_pengajuanCuti')->name('pengajuanCuti.getubah');
Route::get('hapus_pengajuanCuti/{id}', 'PengajuanCutiController@hapus_pengajuanCuti')->name('pengajuanCuti.hapus');
Route::get('terima_pengajuanCuti/{id}', 'PengajuanCutiController@terima_pengajuanCuti')->name('pengajuanCuti.terima');
Route::get('tolak_pengajuanCuti/{id}', 'PengajuanCutiController@tolak_pengajuanCuti')->name('pengajuanCuti.tolak');

Route::get('sanksi', 'SanksiController@sanksi')->name('sanksi');
// Route::get('sanksis', 'SanksiController@sanksiWithDate')->name('sanksi.with.date');
Route::post('tambah_sanksi', 'SanksiController@tambah_sanksi')->name('sanksi.tambah');
Route::post('ubah_sanksi', 'SanksiController@ubah_sanksi')->name('sanksi.ubah');
Route::get('get_ubah_sanksi/{id}', 'SanksiController@get_ubah_sanksi')->name('sanksi.getubah');
Route::get('hapus_sanksi/{id}', 'SanksiController@hapus_sanksi')->name('sanksi.hapus');

Route::get('penjualan', 'PenjualanController@penjualan')->name('penjualan');
// Route::get('sanksis', 'SanksiController@sanksiWithDate')->name('sanksi.with.date');
Route::post('tambah_penjualan', 'PenjualanController@tambah_penjualan')->name('penjualan.tambah');
Route::post('ubah_penjualan', 'PenjualanController@ubah_penjualan')->name('penjualan.ubah');
Route::get('get_ubah_penjualan/{id}', 'PenjualanController@get_ubah_penjualan')->name('penjualan.getubah');
Route::get('hapus_penjulan/{id}', 'PenjualanController@hapus_penjualan')->name('penjualan.hapus');


Route::get('kriteria', 'KriteriaController@kriteria')->name('kriteria');
Route::post('tambah_kriteria', 'KriteriaController@tambah_kriteria')->name('kriteria.tambah');
Route::post('ubah_kriteria', 'KriteriaController@ubah_kriteria')->name('kriteria.ubah');
Route::get('get_ubah_kriteria/{id}', 'KriteriaController@get_ubah_kriteria')->name('kriteria.getubah');
Route::get('hapus_kriteria/{id}', 'KriteriaController@hapus_kriteria')->name('kriteria.hapus');

Route::get('indikator', 'IndikatorController@indikator')->name('indikator');
Route::post('tambah_indikator', 'IndikatorController@tambah_indikator')->name('indikator.tambah');
Route::post('ubah_indikator', 'IndikatorController@ubah_indikator')->name('indikator.ubah');
Route::get('get_ubah_indikator/{id}', 'IndikatorController@get_ubah_indikator')->name('indikator.getubah');
Route::get('hapus_indikator/{id}', 'IndikatorController@hapus_indikator')->name('indikator.hapus');

Route::get('form_penilaian', 'FormPenilaianController@form_penilaian')->name('form_penilaian');
Route::post('tambah_form_penilaian', 'FormPenilaianController@tambah_form_penilaian')->name('form_penilaian.tambah');
Route::post('ubah_form_penilaian', 'FormPenilaianController@ubah_form_penilaian')->name('form_penilaian.ubah');
Route::get('get_ubah_form_penilaian/{id}', 'FormPenilaianController@get_ubah_form_penilaian')->name('form_penilaian.getubah');
Route::get('hapus_form_penilaian/{id}', 'FormPenilaianController@hapus_form_penilaian')->name('form_penilaian.hapus');


// Route::get('detil_form_penilaian', 'detilFormPenilaianController@detil_form_penilaian')->name('detil_form_penilaian');
Route::get('get_ubah_detil_form_penilaian/{id}', 'FormPenilaianController@get_ubah_detil_form_penilaian')->name('form_detil_penilaian.getubah');
Route::get('hapus_detil_form_penilaian/{id}', 'FormPenilaianController@hapus_detil_form_penilaian')->name('detil_form_penilaian.hapus');
Route::post('tambah_detil_form_penilaian', 'FormPenilaianController@tambah_detil_form_penilaian')->name('detil_form_penilaian.tambah');



Route::get('penilaians', 'PenilaianController@penilaianWithDate')->name('penilaian.with.date');
Route::get('penilaian', 'PenilaianController@penilaian')->name('penilaian');
Route::post('tambah_penilaian', 'PenilaianController@tambah_penilaian')->name('penilaian.tambah');
Route::post('ubah_penilaian', 'PenilaianController@ubah_penilaian')->name('penilaian.ubah');
Route::get('get_ubah_penilaian/{id}', 'PenilaianController@get_ubah_penilaian')->name('penilaian.getubah');
Route::get('hapus_penilaian/{id}', 'PenilaianController@hapus_penilaian')->name('penilaian.hapus');
Route::post('ubah_penilaian_nilai', 'PenilaianController@ubah_penilaian_nilai')->name('penilaian.ubahNilai');


Route::get('penghargaans', 'PenghargaanController@penghargaan')->name('penghargaan');
Route::get('penghargaan', 'PenghargaanController@penghargaanWithDate')->name('penghargaanWithDate');
Route::post('tambah_penghargaan', 'PenghargaanController@tambah_penghargaan')->name('penghargaan.tambah');
Route::post('ubah_penghargaan', 'PenghargaanController@ubah_penghargaan')->name('penghargaan.ubah');
Route::get('get_ubah_penghargaan/{id}', 'PenghargaanController@get_ubah_penghargaan')->name('penghargaan.getubah');
Route::get('hapus_penghargaan/{id}', 'PenghargaanController@hapus_penghargaan')->name('penghargaan.hapus');
Route::get('terima_penghargaan/{id}', 'PenghargaanController@terima_penghargaan')->name('penghargaan.terima');
Route::get('tolak_penghargaan/{id}', 'PenghargaanController@tolak_penghargaan')->name('penghargaan.tolak');



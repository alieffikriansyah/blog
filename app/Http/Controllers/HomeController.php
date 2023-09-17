<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departemen;
use App\Karyawan;
use App\Jabatan;
use Illuminate\Support\Facades\DB;
use stdClass;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');

        // NEW IMPLEMENTATION -- START --

        $total_karyawan = Karyawan::all()->count();
        $total_departemen = Departemen::all()->count();

        $total_sanksi = DB::select('
            SELECT count(1) as total_sanksi 
            FROM sanksi 
            WHERE MONTH(waktu_sanksi) = MONTH(now()) 
            AND YEAR(waktu_sanksi) = YEAR(now())
        ')[0]->total_sanksi;

        $absen_todays = DB::select('
            SELECT karyawan_id_karyawan, name, tipe_absensi
            FROM absensi 
            INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN users ON users.id = karyawan.user_id_user
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(now()) 
            AND MONTH(tanggaldanwaktu_absensi) = MONTH(now()) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(now())
        ');
        $absen_todays = json_encode($absen_todays);

        // var_dump('DEBUG >>>>>>');
        // var_dump($absen_todays);
        // var_dump('DEBUG >>>>>>');

        // NEW IMPLEMENTATION -- END --

        $karyawan = DB::select('
            SELECT name, nama_departemen, nama_jabatan, id_karyawan, gaji_pokok
            FROM karyawan
            INNER JOIN departemen on karyawan.departemen_id_departemen = departemen.id_departemen
            INNER JOIN jabatan on karyawan.jabatan_id_jabatan = jabatan.id_jabatan
            INNER JOIN users ON users.id = karyawan.user_id_user
        ');

        $result = [];
        // get current month and year
        $days = date('d');
        $months = date('m');
        $years = date('Y');

        foreach ($karyawan as $k) {
            $karyawanTemp = new stdClass();

            $nilaiAbsen = self::getNilaiAbsenPerKaryawan($k->id_karyawan, $months, $years)/100;
            $nilaiSanksi = self::getNilaiSanksiPerKaryawan($k->id_karyawan, $months, $years)/100;
            $nilaiPenilaian = self::getFormPenilaianPerKaryawan($k->id_karyawan, $months, $years)/100;

            $bonusGaji = $k->gaji_pokok * $nilaiAbsen * $nilaiSanksi * $nilaiPenilaian;

            $gajiTotal = $k->gaji_pokok + $bonusGaji;

            $karyawanTemp->karyawan = $k;
            $karyawanTemp->gajiTotal = $gajiTotal;
            $karyawanTemp->bonusGaji = $bonusGaji;
            $karyawanTemp->nilaiAbsen = number_format($nilaiAbsen*100, 2, '.', '');
            $karyawanTemp->nilaiSanksi = number_format($nilaiSanksi*100, 2, '.', '');
            $karyawanTemp->nilaiPenilaian = number_format($nilaiPenilaian*100, 2, '.', '');

            array_push($result, $karyawanTemp);
        }

        // Sorting dari Gaji Bonus
        usort($result, function($a, $b) {return $a->bonusGaji < $b->bonusGaji;});

        // get cuti perbulan
        $tempDate = date_create($years."-".$months);

        $cutiPerMonth = DB::select('
            SELECT idpengajuan_cuti ,karyawan_id_karyawan, name, tanggal_mulai_cuti, keterangan_cuti, status_cuti
            FROM pengajuan_cuti
            INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN users ON users.id = karyawan.user_id_user
            AND MONTH(tanggal_mulai_cuti) = MONTH(?) 
            AND YEAR(tanggal_mulai_cuti) = YEAR(?)
        ', [$tempDate, $tempDate]);

        $sanksiPerMonth = DB::select('
            SELECT id_sanksi, name, keterangan_sanksi, waktu_sanksi
            FROM sanksi
            INNER JOIN karyawan ON sanksi.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN users ON users.id = karyawan.user_id_user
            AND MONTH(waktu_sanksi) = MONTH(?) 
            AND YEAR(waktu_sanksi) = YEAR(?)
        ', [$tempDate, $tempDate]);

        $tempDates = date_create($years."-".$months."-".$days);

        $absenPerDay = DB::select('
            SELECT karyawan_id_karyawan, name, tipe_absensi, tanggaldanwaktu_absensi
            FROM absensi 
            INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN users ON users.id = karyawan.user_id_user
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
            AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
        ', [$tempDates, $tempDates, $tempDates]);

        if(Auth::user()->karyawan){
            $karyawan =  karyawan::where('user_id_user', Auth::user()->id)->get();

            $departemen = Departemen::all();
            $jabatan = Jabatan::all();

            return view('karyawan', compact('karyawan', 'departemen', 'jabatan'));
        }

        return view('dashboardAdmin', compact(
            'total_karyawan',
            'total_departemen',
            'total_sanksi',
            'absen_todays',
            'result',
            'cutiPerMonth',
            'sanksiPerMonth',
            'absenPerDay'));
    }

    public function getNilaiAbsenPerKaryawan($id_karyawan, $months, $years) {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$months,$years);
        $tempDate = date_create($years."-".$months);
        $jumlahAbsenPerBulan = DB::select('
            SELECT count(id_absensi) as count
            FROM absensi 
            WHERE MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
            AND karyawan_id_karyawan = (?)
            AND tipe_absensi in (\'hadir\', \'cuti\',  \'telat\',  \'izin\')
        ', [$tempDate, $tempDate, $id_karyawan]);

        // var_dump($jumlahAbsenPerBulan);

        return $jumlahAbsenPerBulan[0]->count/$days_in_month*100;
    }

    public function getNilaiSanksiPerKaryawan($id_karyawan, $months, $years) {
        $tempDate = date_create($years."-".$months);
        $jumlahSanksiPerBulan = DB::select('
            SELECT count(id_sanksi) as count
            FROM sanksi 
            WHERE MONTH(waktu_sanksi) = MONTH(?) 
            AND YEAR(waktu_sanksi) = YEAR(?)
            AND karyawan_id_karyawan = (?)
        ', [ $tempDate, $tempDate, $id_karyawan]);

        if ($jumlahSanksiPerBulan[0]->count == 0) {
            return 100;
        } else if ($jumlahSanksiPerBulan[0]->count == 1) {
            return 50;
        } else if ($jumlahSanksiPerBulan[0]->count == 2) {
            return 40;
        }

        return 30;
    }

    public function getFormPenilaianPerKaryawan($id_karyawan, $months, $years) {
        $tempDate = date_create($years."-".$months);
        $penilaianPerKaryawan = DB::select('
            SELECT nilai_skor
            FROM penilaian 
            WHERE MONTH(waktu_penilaian) = MONTH(?) 
            AND YEAR(waktu_penilaian) = YEAR(?)
            AND karyawan_id_karyawan = (?)
            LIMIT 1
        ', [$tempDate, $tempDate, $id_karyawan]);

        if (count($penilaianPerKaryawan) == 0) {
            return 0;
        }

        return $penilaianPerKaryawan[0]->nilai_skor;
    }
}

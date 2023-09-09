<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\log;
use App\absensi;
use App\Karyawan;
use Auth;

class detailNilaiBonusKehadiranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detailNilaiBonusKehadiran(Request $request)
    {
    //     // dd($request);
    //     // $request->user();
        $request->user();
        // dd($request);


        $paths = explode('-', $request->query('date'));
        $months = date('m');
        $years = date('Y');

        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }

        

        $absensi = Absensi::all();
        $karyawan = Karyawan::all();

        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$months,$years);

        $arrDays = [];
        $arrTimes = [];
        $allAbsenPerDay = [];
        

        
       



        for ($i = 1; $i <= $days_in_month; $i++) {
            $tempDate = date_create($years . "-" . $months . "-" . $i);
            array_push($arrDays, date_format($tempDate, "l, jS F Y"));
            array_push($arrTimes, $tempDate->format('Y-m-d'));

            $query = '
            SELECT karyawan_id_karyawan, tanggaldanwaktu_absensi as waktu, tipe_absensi as masuk,  count(id_absensi) as hadir, count(id_absensi) as total
             FROM absensi 
            INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
             AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
            AND tipe_absensi in (\'hadir\')
        ';

        if(Auth::user()->karyawan){
            $query .= ' AND karyawan.user_id_user = ' . Auth::user()->id;
        }

        $detailNilaiBonusKehadiran = DB::select(($query), [$tempDate, $tempDate, $tempDate]);

            array_push($arrTimes,$allAbsenPerDay, $absen);
        }
    //     $days_in_month = cal_days_in_month(CAL_GREGORIAN,$months,$years);
    //     $tempDate = date_create($years."-".$months);
        
    // $detailNilaiBonusKehadiran = ' SELECT karyawan_id_karyawan, tanggaldanwaktu_absensi as waktu, tipe_absensi as masuk,  count(id_absensi) as hadir, count(id_absensi) as total
    // FROM absensi 
    // INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
    // AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
    // AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)';
    

    //  if(Auth::user()->karyawan){
    //         $query .= ' AND karyawan.user_id_user = ' . Auth::user()->id;
    //     }
    //     $detailNilaiBonusKehadiran= DB::select(($query), [$tempDate, $tempDate,$id_karyawan]);


        // dd($detailNilaiBonusKehadiran);
        return view('detailNilaiBonusKehadiran', compact('detailNilaiBonusKehadiran'));
        // return view('absensi', compact('absensi', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan'));
     
    }
}

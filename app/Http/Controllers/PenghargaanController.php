<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\karyawan;
use App\absensi;
use App\jabatan;
use App\penilaian;
use App\sanksi;
use App\User;
use Auth;

use stdClass;

class PenghargaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    // public function penghargaan (Request $request){

    //     $request->user();
        

    //     $karyawan = karyawan::all();
    //     $jabatan = Jabatan::all();
    //     $absen = absensi::all();
    //     $penilaian = penilaian::all();
    //     $sanksi = sanksi::all();

    //     $days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    //     $days = date('d');
    //     $months = date('m');
    //     $months_name = date('M');
    //     $years = date('Y');

    //     $arrDays = [];
    //     $arrTimes = [];
    //     $allAbsenPerDay = [];

    //     for ($i=1; $i <= $days_in_month; $i++) {
    //         $tempDate = date_create($years."-".$months."-".$i);
    //         array_push($arrDays, date_format($tempDate, "l, jS F Y"));
    //         array_push($arrTimes, $tempDate->format('Y-m-d'));

    //         $absen = DB::select('
    //         SELECT idpengajuan_cuti ,karyawan_id_karyawan, nama, tanggal_mulai_cuti, keterangan_cuti, status_cuti
    //         FROM pengajuan_cuti
    //         INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
    //         AND MONTH(tanggal_mulai_cuti) = MONTH(?) 
    //         AND YEAR(tanggal_mulai_cuti) = YEAR(?)
    //         ', [$tempDate, $tempDate]);

    //         array_push($allAbsenPerDay, $absen);
    //         // dd($absen);
    //     }

    //     // var_dump($countAbsenPerDays);

    //     return view('penghargaans',
    //     compact('penghargaans', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan'));
    // }

    public function penghargaan ()
    {

        // to get current month and year
        $months = date('m');
        $years = date('Y');
        $query = '
        SELECT nama_departemen, nama_jabatan, id_karyawan, gaji_pokok, nilai_bonus_gaji,name
        FROM karyawan

        INNER JOIN departemen on karyawan.departemen_id_departemen = departemen.id_departemen

        INNER JOIN jabatan on karyawan.jabatan_id_jabatan = jabatan.id_jabatan
        
        INNER JOIN users ON karyawan.user_id_user = users.id
    ';


        if(Auth::user()->karyawan){
            $query .= ' WHERE karyawan.user_id_user = ' . Auth::user()->id;
        }

        $karyawan = DB::select($query);

        $result = [];
        foreach ($karyawan as $k) {
    

                $karyawanTemp = new stdClass();
            
       
                $nilaiAbsen = self::getNilaiAbsenPerKaryawan($k->id_karyawan, $months, $years);
                $nilaiSanksi = self::getNilaiSanksiPerKaryawan($k->id_karyawan, $months, $years)/100;
                $nilaiPenilaian = self::getFormPenilaianPerKaryawan($k->id_karyawan, $months, $years);
              
    
                $bonusGaji =( $nilaiAbsen + $nilaiPenilaian  ) * $nilaiSanksi;
            
    
                $gajiTotal = $k->gaji_pokok + $bonusGaji;
    
                $karyawanTemp->karyawan = $k;
               
                $karyawanTemp->gajiTotal = $gajiTotal;
                $karyawanTemp->bonusGaji = $bonusGaji;
                $karyawanTemp->nilaiAbsen = $nilaiAbsen;
                $karyawanTemp->nilaiSanksi = $nilaiSanksi;
                $karyawanTemp->nilaiPenilaian = $nilaiPenilaian;
              
    
                array_push($result, $karyawanTemp);

            

          
        }
        // dd($result);

        return view('penghargaan', compact('months', 'years',  'result'));

    }
    
    public function penghargaanWithDate (Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        // $request->user();
        // dd($request);
        $paths = explode('-',$request->query('date'));
        // dd($path)
        // to get current month and year
        $months = date('m');
        $years = date('Y');
        
        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }
        
       
        $karyawan = DB::select('
        SELECT nama_departemen, nama_jabatan, id_karyawan, gaji_pokok, nilai_bonus_gaji,name
        FROM karyawan

        INNER JOIN departemen on karyawan.departemen_id_departemen = departemen.id_departemen

        INNER JOIN jabatan on karyawan.jabatan_id_jabatan = jabatan.id_jabatan
        
        INNER JOIN users ON karyawan.user_id_user = users.id
        ');

        $result = [];

        foreach ($karyawan as $k) {
           

                $karyawanTemp = new stdClass();
             
          
                $nilaiAbsen = self::getNilaiAbsenPerKaryawan($k->id_karyawan, $months, $years);
                $nilaiSanksi = self::getNilaiSanksiPerKaryawan($k->id_karyawan, $months, $years)/100;
                $nilaiPenilaian = self::getFormPenilaianPerKaryawan($k->id_karyawan, $months, $years);
              
    
                $bonusGaji =( $nilaiAbsen + $nilaiPenilaian  ) * $nilaiSanksi;
            
    
                $gajiTotal = $k->gaji_pokok + $bonusGaji;
    
                $karyawanTemp->karyawan = $k;
   
                $karyawanTemp->gajiTotal = $gajiTotal;
                $karyawanTemp->bonusGaji = $bonusGaji;
                $karyawanTemp->nilaiAbsen = $nilaiAbsen;
                $karyawanTemp->nilaiSanksi = $nilaiSanksi;
                $karyawanTemp->nilaiPenilaian = $nilaiPenilaian;
              
    
                array_push($result, $karyawanTemp);

            

            // dd($result);
        }
  

        return view('penghargaan', compact('penghargaan', 'months', 'years', 'karyawan', 'result'));

    }

    public function getNilaiAbsenPerKaryawan($id_karyawan, $months, $years) 
    {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$months,$years);
        $tempDate = date_create($years."-".$months);
        $jumlahAbsenPerBulan = DB::select('
            SELECT count(id_absensi) as count
            FROM absensi 
            WHERE MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
            AND karyawan_id_karyawan = (?)
            AND tipe_absensi in (\'hadir\')
        ', [$tempDate, $tempDate, $id_karyawan]);

        // dd($jumlahAbsenPerBulan);

         if($jumlahAbsenPerBulan[0]->count/$days_in_month) {
            return  30000;
        }
       
    }
       
    public function getNilaiSanksiPerKaryawan($id_karyawan, $months, $years) 
    {
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
        } 

        return 0;
    }

    
    public function getFormPenilaianPerKaryawan($id_karyawan, $months, $years) 
    {
        $tempDate = date_create($years."-".$months);
        $penilaianPerKaryawan = DB::select('
            SELECT nilai_skor
            FROM penilaian 
            WHERE MONTH(waktu_penilaian) = MONTH(?) 
            AND YEAR(waktu_penilaian) = YEAR(?)
            AND karyawan_id_karyawan = (?)
            LIMIT 1
        ', [$tempDate, $tempDate, $id_karyawan]);

        // dd($penilaianPerKaryawan);
        // if ($penilaianPerKaryawan == 100) {
        //     return 500000;
        // }elseif ($penilaianPerKaryawan <= 75 && $penilaianPerKaryawan >= 99) {
        //     return 250000;
        // }elseif ($penilaianPerKaryawan <= 74) {
        //     return 0;
        // }
        // if($penilaianPerKaryawan[0]->nilai_skor == 100){
        //     return 500000;
        // }else if($penilaianPerKaryawan[0]->nilai_skor <= 75 && $penilaianPerKaryawan[0]->nilai_skor >= 74){
        //     return 250000;
        // }
            if($penilaianPerKaryawan[0]->nilai_skor ==  100){
                return 500000;
            } else if($penilaianPerKaryawan[0]->nilai_skor >= 75 && $penilaianPerKaryawan[0]->nilai_skor <= 99 ){
                return 250000;
            }else {
                return 0;
            }
        
    }


    // public function get_absen_penghargaan($day)
    // {
    //     $time = strtotime($day);
    //     $time = date('Y-m-d', $time);

    //     $absen_todays = DB::select('
    //         SELECT *
    //         FROM Penghargaan 
    //         INNER JOIN karyawan ON Penghargaan.karyawan_id_karyawan = karyawan.id_karyawan
    //         WHERE DAY(tanggaldanwaktu_penghargaan) = DAY(?) 
    //         AND MONTH(tanggaldanwaktu_penghargaan) = MONTH(?) 
    //         AND YEAR(tanggaldanwaktu_penghargaan) = YEAR(?)
    //     ', [$time, $time, $time]);
    //     echo json_encode($absen_todays);

    //     exit;

    // }


}
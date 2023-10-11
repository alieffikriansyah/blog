<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pengajuanCuti;
use App\karyawan;
use App\Absensi;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class PengajuanCutiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function PengajuanCuti(Request $request)
    // {
    //     // $request->user()->authorizeRoles(['superadmin', 'admin']);
    //     $request->user();

    //     // if(Auth::user()->karyawan){
    //     //     $karyawanId = Auth::user()->karyawan->id;
    //     //     $PengajuanCuti = pengajuanCuti::where('karyawan_id_karyawan', $karyawanId)->get();
    //     // } else {
    //     //     $PengajuanCuti = pengajuanCuti::all();
    //     // }

    //     $PengajuanCuti = pengajuanCuti::all();
    //     $karyawan = karyawan::all();

    //     $days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    //     $days = date('d');
    //     $months = date('m');
    //     $months_name = date('M');
    //     $years = date('Y');

    //     $arrDays = [];
    //     $arrTimes = [];
    //     $allAbsenPerDay = [];

    //     for ($i = 1; $i <= $days_in_month; $i++) {
    //         $tempDate = date_create($years . "-" . $months . "-" . $i);
    //         array_push($arrDays, date_format($tempDate, "l, jS F Y"));
    //         array_push($arrTimes, $tempDate->format('Y-m-d'));

    //         $absen = DB::select('
    //             SELECT idpengajuan_cuti ,karyawan_id_karyawan, nama, tanggal_mulai_cuti, keterangan_cuti, status_cuti
    //             FROM pengajuan_cuti
    //             INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
    //             AND MONTH(tanggal_mulai_cuti) = MONTH(?) 
    //             AND YEAR(tanggal_mulai_cuti) = YEAR(?)
    //         ', [$tempDate, $tempDate]);

    //         array_push($allAbsenPerDay, $absen);
    //     }

    //     // var_dump($countAbsenPerDays);

    //     return view(
    //         'PengajuanCuti',
    //         compact('PengajuanCuti', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan')
    //     );
    // }

    public function pengajuanCutiWithDate(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();
        // dd($request);

        $paths = explode('-', $request->query('date'));

        // to get current month and year
        $months = date('m');
        $years = date('Y');

        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }

        // var_dump($date);
        // return;

        // var_dump($paths);

        $PengajuanCuti = PengajuanCuti::all();
        $karyawan = Karyawan::all();

        // var_dump($months, $years);

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $arrDays = [];
        $arrTimes = [];
       

        $tempDate = date_create($years . "-" . $months);
        array_push($arrDays, date_format($tempDate, "l, jS F Y"));
        array_push($arrTimes, $tempDate->format('Y-m-d'));

        


         if(Auth::user()->karyawan){
            $karyawanId = Auth::user()->karyawan->id_karyawan;
            // dd(Auth::user()->karyawan->id_karyawan);
            $cutiPerMonth = DB::select('
                SELECT idpengajuan_cuti ,karyawan_id_karyawan, name, tanggal_mulai_cuti, tanggal_selesai_cuti, keterangan_cuti, status_cuti
                FROM pengajuan_cuti
                INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
                INNER JOIN users ON karyawan.user_id_user = users.id
                WHERE pengajuan_cuti.karyawan_id_karyawan = ?
                AND MONTH(tanggal_mulai_cuti) && MONTH(tanggal_selesai_cuti) = MONTH(?) 
                AND YEAR(tanggal_mulai_cuti) && YEAR(tanggal_selesai_cuti) = YEAR(?)
               
              
            ', [$karyawanId, $tempDate, $tempDate]);
            // dd($cutiPerMonth);
        } else {
            $cutiPerMonth = DB::select('
                SELECT idpengajuan_cuti ,karyawan_id_karyawan, name, tanggal_mulai_cuti, tanggal_selesai_cuti, keterangan_cuti, status_cuti
                FROM pengajuan_cuti
                INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
                INNER JOIN users ON karyawan.user_id_user = users.id
                WHERE MONTH(tanggal_mulai_cuti) && MONTH(tanggal_selesai_cuti) = MONTH(?) 
                AND YEAR(tanggal_mulai_cuti) && YEAR(tanggal_selesai_cuti) = YEAR(?)
              
            ', [$tempDate, $tempDate]);
            // dd($cutiPerMonth);
        }

        // var_dump($cutiPerMonth);

        return view('pengajuanCuti', compact('PengajuanCuti', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'cutiPerMonth', 'karyawan'));
    }

    public function tambah_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Pengajuan Cuti',
                'fitur' => 'pengajuanCuti'
            ]);
        
            $currentYear = Carbon::now()->year;
            $karyawan = PengajuanCuti::where('karyawan_id_karyawan','=',$request->karyawan )->get(); 
            
            
                
            // dd($karyawan);
             // $karyawan = Karyawan::Where('id_karyawan','=', $id_karyawan)->get();   
            // $tanggalMulai = PengajuanCuti::where('tanggal_mulai_cuti','=',$request->tanggal_mulai_cuti)->get();
            // $tanggalSelesai = PengajuanCuti::where('tanggal_selesai_cuti','=',$request->tanggal_selesai_cuti)->get();
            $totalCuti = 0;
            $batasCuti = 10;
            $endDate = Carbon::now()->year;
            foreach($karyawan as $kar){
            $startDate = Carbon::parse( $kar->tanggal_mulai_cuti);
            $endDate = Carbon::parse($kar->tanggal_selesai_cuti);
           
            // Menghitung selisih hari antara tanggal awal dan akhir
             $hariCuti = $startDate->diffInDays($endDate);
            //  dd($hariCuti);
             $totalCuti += $hariCuti;
             
             $endDate = Carbon::parse($endDate);
             $yearOnly = $endDate->year;
         
            }

            $sisaCuti = $batasCuti - $totalCuti;
        //    dd($totalCuti,$batasCuti);


             if ($totalCuti <= $sisaCuti && $yearOnly <= $currentYear) {
                $PengajuanCuti = new PengajuanCuti();
                $PengajuanCuti->status_cuti = 'pending';
                $PengajuanCuti->karyawan_id_karyawan = $request->karyawan;
                $PengajuanCuti->tanggal_mulai_cuti = $request->tanggal_mulai_cuti;
                $PengajuanCuti->tanggal_selesai_cuti = $request->tanggal_selesai_cuti;
                $PengajuanCuti->keterangan_cuti = $request->keterangan_cuti;
                $PengajuanCuti->save();
            } else {
                 // Di dalam controller
                 return redirect()->back()->with('error', 'Karyawan tidak dapat mengambil cuti, karena telah melakukan cuti lebih dari 10 hari dalam setahun.');
            }
              
            DB::commit();
            return back()->with('success', 'Data PengajuanCuti baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }


    public function terima_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            $PengajuanCuti = PengajuanCuti::find($request->id);

            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Terima Pengajuan Cuti untuk karyawan id ' . $PengajuanCuti->karyawan_id_karyawan,
                'fitur' => 'pengajuanCuti'
            ]);
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Presensi Karyawan (Terima Cuti)',
                'fitur' => 'presensi'
            ]);

            $PengajuanCuti->status_cuti = 'terima';

            $PengajuanCuti->save();

            // setelah cuti diterima, insert ke absensi sesuai dari cuti yang diterima
            $selisihHariInTime = strtotime($PengajuanCuti->tanggal_selesai_cuti) - strtotime($PengajuanCuti->tanggal_mulai_cuti);
            $selisihHari = round($selisihHariInTime / (60 * 60 *24)) + 1;
            $tglCuti = date_create($PengajuanCuti->tanggal_mulai_cuti);
            for ($i=0; $i < $selisihHari; $i++) { 
                // insert absensi dari tanggal_mulai_cuti - tanggal_selesai_cuti
                print_r($tglCuti);
                $absensi = new Absensi();
                $absensi->karyawan_id_karyawan = $PengajuanCuti->karyawan_id_karyawan;
                $absensi->tanggaldanwaktu_absensi = $tglCuti;
                $absensi->status_hari = 'masuk';
                $absensi->tipe_absensi = 'cuti';
                $absensi->keterangan_absensi = 'cuti - ' . $PengajuanCuti->keterangan_cuti;
                $absensi->save();

                // nambah tanggal
                $tglCuti = date_add($tglCuti,date_interval_create_from_date_string("1 day") );
            }

            // dd($selisihHari);

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil diterima');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }

    public function tolak_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tolak Pengajuan Cuti',
                'fitur' => 'pengajuanCuti'
            ]);
            $PengajuanCuti = PengajuanCuti::find($request->id);
            $PengajuanCuti->status_cuti = 'tolak';

            $PengajuanCuti->save();

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil ditolak');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }

    public function get_ubah_pengajuanCuti($id_pengajuanCuti)
    {
        $PengajuanCuti = PengajuanCuti::find($id_pengajuanCuti);
        $arr = json_decode($PengajuanCuti, true);

        $karyawan = Karyawan::all();
        $arr['karyawan'] = $karyawan;

        echo json_encode($arr);

        exit;
    }


    public function get_absen_pengajuanCuti($day)
    {
        $time = strtotime($day);
        $time = date('Y-m-d', $time);

        $absen_todays = DB::select('
            SELECT *
            FROM PengajuanCuti 
            INNER JOIN karyawan ON PengajuanCuti.karyawan_id_karyawan = karyawan.id_karyawan
            WHERE DAY(tanggaldanwaktu_pengajuanCuti) = DAY(?) 
            AND MONTH(tanggaldanwaktu_pengajuanCuti) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_pengajuanCuti) = YEAR(?)
        ', [$time, $time, $time]);
        echo json_encode($absen_todays);

        exit;
    }

    public function ubah_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Updatr Pengajuan Cuti ',
                'fitur' => 'pengajuanCuti'
            ]);
            $PengajuanCuti = PengajuanCuti::find($request->id_ubah);
            $PengajuanCuti->karyawan_id_karyawan = $request->karyawan_ubah;
            $PengajuanCuti->tanggaldanwaktu_pengajuanCuti = $request->tanggaldanwaktu_pengajuanCuti_ubah;
            $PengajuanCuti->tipe_pengajuanCuti = $request->tipe_pengajuanCuti_ubah;
            $PengajuanCuti->keterangan_pengajuanCuti = $request->keterangan_pengajuanCuti_ubah;
            $PengajuanCuti->status_hari = $request->status_hari_ubah;
            $PengajuanCuti->keterangan_cuti = $request->keterangan_cuti_ubah;

            $PengajuanCuti->save();

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function hapus_pengajuanCuti($id_pengajuanCuti)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Pengajuan Cuti',
                'fitur' => 'pengajuanCuti'
            ]);
            PengajuanCuti::find($id_pengajuanCuti)->delete();

            DB::commit();
            return back()->with('success', 'PengajuanCuti telah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
}

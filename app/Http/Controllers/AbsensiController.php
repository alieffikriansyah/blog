<?php

namespace App\Http\Controllers;

use App\absensi;
use App\karyawan;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function absensi(Request $request)
    // {
    //     // dd($request);
    //     // $request->user()->authorizeRoles(['superadmin', 'admin']);
    //     $request->user();

    //     $absensi = Absensi::all();
    //     $karyawan = Karyawan::all();

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

    //         $query = '
    //         SELECT karyawan_id_karyawan, tipe_absensi, user_id_user
    //         FROM absensi 
    //         INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
    //         WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
    //         AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
    //         AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
    //     ';

    //     if(Auth::user()->karyawan){
    //         $query .= ' AND karyawan.user_id_user = ' . Auth::user()->id;
    //     }

    //         $absen = DB::select(($query), [$tempDate, $tempDate, $tempDate]);

    //         array_push($allAbsenPerDay, $absen);
    //     }

    //     // var_dump($countAbsenPerDays);

    //     return view(
    //         'absensi',
    //         compact('absensi', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan')
    //     );
    // }

    public function absensiWithDate(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();

        $paths = explode('-', $request->query('date'));
        $months = date('m');
        $years = date('Y');

        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }


        // var_dump($date);
        // return;

        // var_dump($paths);

        $isKaryawan = false;

       $absensi = Absensi::all();
        $karyawan = Karyawan::all();

        // var_dump($months, $years);

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $months, $years);
        

        $arrDays = [];
        $arrTimes = [];
        $allAbsenPerDay = [];
        $alreadyAbsen = false;

       for ($i = 1; $i <= $days_in_month; $i++) {
            $tempDate = date_create($years . "-" . $months . "-" . $i);
            array_push($arrDays, date_format($tempDate, "l, jS F Y"));
            array_push($arrTimes, $tempDate->format('Y-m-d'));

            $query = '
            SELECT karyawan_id_karyawan, tipe_absensi, user_id_user
            FROM absensi 
            INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
            AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
        ';

        if(Auth::user()->karyawan){
            $isKaryawan = true;
            $query .= ' AND karyawan.user_id_user = ' . Auth::user()->id;
        }

            $absen = DB::select(($query), [$tempDate, $tempDate, $tempDate]);

            array_push($allAbsenPerDay, $absen);
        }

        if ($isKaryawan) {
            $currentDay = date('j');
            $arrDays = [$arrDays[$currentDay-1]];
            $arrTimes = [$arrTimes[$currentDay-1]];
            $allAbsenPerDay =  [$allAbsenPerDay[$currentDay-1]];

            
            if (count($allAbsenPerDay[0]) > 0) {    
                $alreadyAbsen = true;
            }
        }

        return view('absensi', compact('absensi', 'days_in_month', 'months', 'years','arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan', 'isKaryawan', 'alreadyAbsen'));
    }

    public function tambah_absensi(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Presensi Karyawan',
                'fitur' => 'presensi'
            ]);

            $absensi = new Absensi();
            $absensi->karyawan_id_karyawan = $request->karyawan;
            $absensi->tanggaldanwaktu_absensi = $request->tanggaldanwaktu_absensi;
            if(Auth::user()->karyawan){
                $absensi->status_hari = 'masuk';
            } else {
                $absensi->status_hari = $request->status_hari;
            }
            
            if ($request->keterangan_absensi) {
                $absensi->keterangan_absensi = $request->keterangan_absensi;
            }

            if(Auth::user()->karyawan){
             $absensi->tipe_absensi = $request->tipe_absensi;
             $jamMasuk =   $absensi->tanggaldanwaktu_absensi;
             $jamBatasTerlambat = Carbon::createFromTime(10, 15, 0, 'Asia/Jakarta');
             $jamMasuk = Carbon::now();
                if (  $jamMasuk >= $jamBatasTerlambat){
                
                    $absensi->tipe_absensi = 'telat';
                }
                else{
                    $absensi->tipe_absensi= 'hadir';
                }
                // dd($jamMasuk);
            //     $request->validate([
            //         'karyawan_id_karyawan' => 'required|exists:karyawan,id' // Pastikan ada validasi karyawan
                    
            //     ]);
            
            //  $absenSama = absensi::where('karyawan_id_karyawan',  $absensi->karyawan_id_karyawan);
            //     if ($absenSama) {
            //         return redirect()->back()->with('error', 'Karyawan sudah presensi pada tanggal yang sama.');
            //     }
            //     else{
            //         $absensi->karyawan_id_karyawan = $request->karyawan;
            //     }
     
            } 
            else {
                $absensi->tipe_absensi = $request->tipe_absensi;   
            }
           


            $absensi->save();
            DB::commit();
            return back()->with('success', 'Data absensi baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function get_ubah_absensi($id_absensi)
    {
        $absensi = Absensi::find($id_absensi);
        $arr = json_decode($absensi, true);

        
        $arr['karyawan'] = DB::table('karyawan')->join('users', 'users.id','=', 'karyawan.user_id_user')->select('*')->get();

        echo json_encode($arr);

        exit;
    }

    public function get_log_absensi($day)
    {
        $time = strtotime($day);
        $time = date('Y-m-d', $time);

        $absen_todays = DB::select('
            SELECT *
            FROM absensi 
            LEFT JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN users ON karyawan.user_id_user = users.id
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
            AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
        ', [$time, $time, $time]);

        echo json_encode($absen_todays);

        exit;
    }


    public function get_absen_absensi($day)
    {
        // dd($day);
        $time = strtotime($day);
        $time = date('Y-m-d', $time);

        $query = '
        SELECT *
        FROM absensi 
        INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
        INNER JOIN users ON karyawan.user_id_user = users.id
        WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
        AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
        AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
    ';

        if(Auth::user()->karyawan){
            $query .= ' AND karyawan.user_id_user = ' . Auth::user()->id;
        }

        $absen_todays = DB::select(($query), [$time, $time, $time]);
        echo json_encode($absen_todays);

        exit;
    }
    public function ubah_absensi(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Ubah Presensi',
                'fitur' => 'presensi'
            ]);
            $absensi = Absensi::find($request->id_ubah);
            $absensi->karyawan_id_karyawan = $request->karyawan_ubah;
            $absensi->tanggaldanwaktu_absensi = $request->tanggaldanwaktu_absensi_ubah;
            $absensi->tipe_absensi = $request->tipe_absensi_ubah;
            $absensi->keterangan_absensi = $request->keterangan_absensi_ubah;
            $absensi->status_hari = $request->status_hari_ubah;
            // $absensi->keterangan_cuti = $request->keterangan_cuti_ubah;

            // UPDATE LOG ABSENSI untuk ID ABSENSI yang diubah
            // CHECK KARYAWAN/ADMIN
            // if(Auth::user()->karyawan){
            //     // INSERT LOG SEBAGAI KARYAWAN - OPERATION -> UPDATE 
            // } else {
            //     // INSERT LOG SEBAGAI ADMIN - OPERATION -> UPDATE
            // }

            $absensi->save();

            DB::commit();
            return back()->with('success', 'Data absensi telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function hapus_absensi($id_absensi)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Presensi',
                'fitur' => 'presensi'
            ]);
            Absensi::find($id_absensi)->delete();

             // ADD LOG ABSENSI untuk ID ABSENSI yang dihapus
            // CHECK KARYAWAN/ADMIN
            // if(Auth::user()->karyawan){
            //     // INSERT LOG SEBAGAI KARYAWAN - OPERATION -> DELETE 
            // } else {
            //     // INSERT LOG SEBAGAI ADMIN - OPERATION -> DELETE
            // }

            DB::commit();
            return back()->with('success', 'Absensi telah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
}

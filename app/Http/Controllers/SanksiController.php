<?php

namespace App\Http\Controllers;

use App\sanksi;
use App\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class SanksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function sanksi(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();
        
        $karyawan = Karyawan::all();

        if(Auth::user()->karyawan ){
            $sanksi = [];
            foreach(Sanksi::all() as $item){
                if($item->karyawan->user->name == 1){
                    $sanksi[] = $item;
                    // dd($item);
                    
                }
            }
        } else {
            $sanksi = Sanksi::all();
        }
       

    

        return view('sanksi', compact('sanksi', 'karyawan'));
     
    }
    
    // public function sanksi(Request $request)
    // {
      
    //     $request->user()->authorizeRoles(['superadmin', 'admin']);

    //     // dd($request->query('date'));  
    //     $paths = explode('-',$request->query('date'));


        // $sanksi = Sanksi::all();
       
        // $days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        // $days = date('d');
        // $months = date('m');
        // // dd($months);

        // $months_name = date('M');
        // $years = date('Y');

        // if (count($paths) > 1) {
        //     $months = (int)$paths[1];
        //     $years = (int)$paths[0];
        // }
        // $sanksi = Sanksi::all();
        // $karyawan = Karyawan::all();
        // $arrDays = [];
        // $arrTimes = [];
        // $allAbsenPerDay = [];
        // // $tempDate="";

        // // for ($i=1; $i <= $days_in_month; $i++) {
        // for ($i=26; $i <= $days_in_month; $i++) {
        //     $tempDate = date_create($years."-".$months."-".$i);

        //     // $tempDate = date_create($years."-".$months."-".$i);
        //     // dd($tempDate);

        //     // array_push($arrDays, date_format($tempDate, "l, jS F Y"));
        //     // array_push($arrTimes, $tempDate->format('Y-m-d'));
            
            
        //     $sanksi = DB::select('
        //         SELECT  karyawan_id_karyawan, keterangan_sanksi, waktu_sanksi
        //         FROM sanksi
        //         INNER JOIN karyawan ON sanksi.karyawan_id_karyawan = karyawan.id_karyawan
        //         WHERE DAY(waktu_sanksi) = DAY(?) 
        //         AND MONTH(waktu_sanksi) = MONTH(?) 
        //         AND YEAR(waktu_sanksi) = YEAR(?)
        //     ', [$tempDate, $tempDate, $tempDate]);
        //     // dd($days_in_month =cal_days_in_month(CAL_GREGORIAN,02,2005));
        //     array_push($allAbsenPerDay, $sanksi);
        //     // dd($sanksi);
        //     // dd ($sanksi = DB::select('
        //     // SELECT  karyawan_id_karyawan, keterangan_sanksi, waktu_sanksi
        //     // FROM sanksi
        //     // INNER JOIN karyawan ON sanksi.karyawan_id_karyawan = karyawan.id_karyawan'));
            
        // }
      

       
    //     return view('sanksi',
    //     // compact('sanksi'));
    //     compact('sanksi', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan'));
    // }
        

    public function tambah_sanksi(Request $request)
    {
        DB::beginTransaction();
        try {
            $sanksi = new Sanksi();
            $sanksi->keterangan_sanksi = $request->keterangan_sanksi;
            $sanksi->waktu_sanksi = $request->waktu_sanksi;
            $sanksi->karyawan_id_karyawan = $request->karyawan;

            $sanksi->save();

            DB::commit();
            return back()->with('success', 'Data sanksi baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_sanksi($id_sanksi)
    {

        $sanksi = Sanksi::find($id_sanksi);
        $arr = json_decode($sanksi, true);
        
        $user = user::all();
        $arr ['user'] =$user;

        $karyawan = Karyawan::all();
        // $karyawan =  karyawan::where('user_id_user', User::find($name))->get();
        $arr['karyawan'] = $karyawan;

        echo json_encode($arr);

        exit;
    }
    public function ubah_sanksi(Request $request)
    {
    //   dd($request);
        DB::beginTransaction();
        try {
            $sanksi = Sanksi::find($request->id_sanksi_ubah);
            $sanksi->keterangan_sanksi = $request->keterangan_sanksi_ubah;
            $sanksi->waktu_sanksi = $request->waktu_sanksi_ubah;
            $sanksi->karyawan_id_karyawan = $request->karyawan_ubah;

            $sanksi->save();

            DB::commit();
            return back()->with('success', 'Data sanksi telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_sanksi($id_sanksi)
    {
        DB::beginTransaction();
        try {
            Sanksi::find($id_sanksi)->delete();
            
            DB::commit();
            return back()->with('success', 'Sanksi telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

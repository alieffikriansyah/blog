<?php

namespace App\Http\Controllers;


use App\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\penjualan;
use Auth;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function penjualan(Request $request)
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

        // dd($request);

        $karyawan = Karyawan::all();

        if(Auth::user()->karyawan){
            $penjualan = [];
            foreach(Penjualan::get() as $item){
                if($item->karyawan->user_id_user == 1){
                    $penjualan[] = $item;
                }
            }
        } else {
            $penjualan = Penjualan::whereMonth('tanggal_penjualan', $months)
                    ->whereYear('tanggal_penjualan', $years)->get();
        }
        


        return view('penjualan', compact('penjualan', 'karyawan', 'months', 'years'));
     
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
        

    public function tambah_penjualan(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Penjualan',
                'fitur' => 'penjualan'
            ]);
            $penjualan = new Penjualan();
            $penjualan->merk = $request->merk;
            $penjualan->jenis_mobil = $request->jenis_mobil;
            $penjualan->harga = $request->harga;
            $penjualan->unit = $request->unit;
            $penjualan->tanggal_penjualan = $request->tanggal_penjualan;
            $penjualan->karyawan_id_karyawan = $request->karyawan;

            $penjualan->save();

            DB::commit();
            return back()->with('success', 'Data sanksi baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_penjualan($id_penjualan)
    {

        $penjualan = Penjualan::find($id_penjualan);
        $arr = json_decode($penjualan, true);
        
        $user = user::all();
        $arr ['user'] =$user;
        
        $karyawan = Karyawan::all();
        $arr['karyawan'] = $karyawan;

        echo json_encode($arr);

        exit;
    }
    public function ubah_penjualan(Request $request)
    {
    //   dd($request);
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Update Penjualan',
                'fitur' => 'penjualan'
            ]);
            $penjualan = Penjualan::find($request->id_penjualan_ubah);
            $penjualan->merk = $request->merk_ubah;
            $sanksi->jenis_mobil= $request->jenis_mobil_ubah;
            $sanksi->harga= $request->harga_ubah;
            $sanksi->unit= $request->unit_ubah;
            $sanksi->tanggal_penjualan = $request->tanggal_penjuaalan_ubah;
            $sanksi->karyawan_id_karyawan = $request->karyawan_ubah;

            $sanksi->save();

            DB::commit();
            return back()->with('success', 'Data sanksi telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_penjualan($id_penjualan)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Penjualan',
                'fitur' => 'penjualan'
            ]);
            Sanksi::find($id_penjualan)->delete();
            
            DB::commit();
            return back()->with('success', 'Sanksi telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

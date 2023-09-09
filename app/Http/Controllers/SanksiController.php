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

        $paths = explode('-',$request->query('date'));
        // dd($path)
        // to get current month and year
        $months = date('m');
        $monthsWithoutZero = date('j');
        $years = date('Y');
        
        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }

        
        $karyawan = Karyawan::all();
        
        $sanksi = [];
        $user= [];

        if(Auth::user()->karyawan){
            $query = DB::select('select * from Karyawan WHERE karyawan.user_id_user = ' . Auth::user()->id);
            // $querySanksi = '
            //     SELECT *
            //     FROM sanksi
            //     inner join karyawan on karyawan.id_karyawan = sanksi.karyawan_id_karyawan
            //     inner join users on users.id = karyawan.user_id_user
            //     WHERE karyawan_id_karyawan = (?) 
            //     AND MONTH(waktu_sanksi) = (?) 
            //     AND YEAR(waktu_sanksi) = (?)
            // ';
            // $sanksi = DB::select($querySanksi, [$query[0]->id_karyawan, $monthsWithoutZero, $years]);

            $sanksi = Sanksi::where('karyawan_id_karyawan', '=',$query[0]->id_karyawan )
                ->whereMonth('waktu_sanksi', $months)
                ->whereYear('waktu_sanksi', $years)
                ->get();

        // if(Auth::user()->karyawan ){
        //     $sanksi = [];
        //     foreach(Sanksi::all() as $item){
        //         if($item->karyawan->user->name){
        //             $sanksi[] = $item;
        //             // dd($item);
                    
        //         }
        //     }
        } else {
            // $querySanksi = '
            //     SELECT *
            //     FROM sanksi
            //     inner join karyawan on karyawan.id_karyawan = sanksi.karyawan_id_karyawan
            //     inner join users on users.id = karyawan.user_id_user
            //     AND MONTH(waktu_sanksi) = (?) 
            //     AND YEAR(waktu_sanksi) = (?)
            // ';
            // $sanksi = DB::select($querySanksi, [$months, $years]);
            $sanksi = Sanksi::whereMonth('waktu_sanksi', $months)
                ->whereYear('waktu_sanksi', $years)
                ->get();
            $user = User::all();
        }
       

    

        return view('sanksi', compact('sanksi','months','years', 'karyawan','user'));
     
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
        // dd($request);
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Sanksi',
                'fitur' => 'sanksi'
            ]);
            $sanksi = new Sanksi();
            $sanksi->keterangan_sanksi = $request->keterangan_sanksi;
            $sanksi->waktu_sanksi = $request->waktu_sanksi;
            $sanksi->karyawan_id_karyawan = $request->karyawan;

            $image = $request->file('foto');
            $name = str_replace(' ', '-', $image->getClientOriginalName());
            $destinationPath = '../public/gallery/';
            $sanksi->foto = $name;
            $image->move($destinationPath, $name);

            //   if(!Auth::user()->karyawan){
            //   $sanksi->users_id = $request->user;
            // //   $karyawan->departemen_id_departemen = $request->departemen;
            //     }


           
     

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
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Update Sanksi',
                'fitur' => 'sanksi'
            ]);
            $sanksi = Sanksi::find($request->id_sanksi_ubah);
            $sanksi->keterangan_sanksi = $request->keterangan_sanksi_ubah;
            $sanksi->waktu_sanksi = $request->waktu_sanksi_ubah;
            $sanksi->karyawan_id_karyawan = $request->karyawan_ubah;
            if($request->file('foto')){
                // unlink('../public/gallery/'.$sanksi->gambar);

                $image = $request->file('foto');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $destinationPath = '../public/gallery/';
                $sanksi->foto = $name;
                $image->move($destinationPath, $name);
            }
            //      if(!Auth::user()->karyawan){
            //   $sanksi->users_id = $request->user;
            //         }
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
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Sanksi',
                'fitur' => 'sanksi'
            ]);
            Sanksi::find($id_sanksi)->delete();
            
            DB::commit();
            return back()->with('success', 'Sanksi telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

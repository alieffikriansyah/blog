<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\User;
use App\admin;
use Auth;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function admin(Request $request)
    {
        $request->user();
        
            $admin = admin::all();

        return view('admin', compact('admin'));
    }

    public function tambah_admin(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Admin',
                'fitur' => 'admin'
            ]);
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->nama;
            $user->password = bcrypt($request->password);
            $user->save();

            $admin = new admin();
            $admin->user_id_user = $user->id;
            $admin->role = $request->role;
            $admin->save();

            DB::commit();
            return back()->with('success', 'Data admin baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }

    }
    public function get_ubah_admin($id_admin)
    {
        // $karyawan = Karyawan::Where('id_karyawan','=', $id_karyawan)->get();   
        $admin = admin::where('id_admin', $id_admin)->with('user')->get();   
        
        // $arr = json_decode($karyawan,true);

        // $departemen = Departemen::all();
        // $arr['departemen'] = $departemen;

        // $jabatan = Jabatan::all();
        // $arr['jabatan'] = $jabatan;

       

        echo json_encode($admin);

        exit;
    }
    public function ubah_admin(Request $request)
    {
        // dd($request);   
        
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Ubah Admin',
                'fitur' => 'admin'
            ]);
            // $tables = DB::select('SHOW karyawan'); 

            // $karyawan = Schema::getColumnListing("karyawan");
            // $dbname = DB::connection()->getDatabaseName();
            // $karyawan = Karyawan::where('id_karyawan', $request->id_karyawan); 

            $admin = admin::find($request->id_admin);
            $user = User::find($admin->user_id_user);

            // dd($user);

            $user->email = $request->email_ubah;
            $user->name = $request->nama_ubah;
            $user->password = bcrypt($request->password_ubah);
         
            $admin->role =  $request->role;
            $user->save();
            $admin->save();

            DB::commit();
            return back()->with('success', 'Data admin telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
       
     }
     public function hapus_admin($id_admin)
     {
         DB::beginTransaction();
         try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'hapus Admin',
                'fitur' => 'admin'
            ]);
             admin::find($id_admin)->delete();
             
             DB::commit();
             return back()->with('success', 'Admin telah berhasil dihapus'); 
         } catch (Exception $e) {
             DB::rollBack();
             return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
         }
     }

}

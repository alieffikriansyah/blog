<?php

namespace App\Http\Controllers;

use App\jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;


class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function jabatan(Request $request)
    {
        $request->user();
        
        $jabatan = Jabatan::all();
        // dd($jabatan);

        return view('jabatan', compact('jabatan'));
    }
    public function tambah_jabatan(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Jabatan',
                'fitur' => 'jabatan'
            ]);
            $jabatan = new Jabatan();
            $jabatan->nama_jabatan = $request->nama_jabatan;
            $jabatan->nilai_bonus_gaji = $request->nilai_bonus_gaji;

            $jabatan->save();

            DB::commit();
            return back()->with('success', 'Data jabatan baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
      
    }
    public function get_ubah_jabatan($id_jabatan)
    {
        $jabatan = Jabatan::find($id_jabatan);   
        $arr = json_decode($jabatan, true);

        echo json_encode($arr);

        exit;
    }
    public function ubah_jabatan(Request $request)
    {

        // $validator = Validator::make($request->all(),[
        //     'nama_jabatan'=>'required',
        //     'nilai_bonus_gaji_ubah'=> 'required|numeric|min:0|max:100',
        // ]);

        // if($validator->fails()){
        //     // dd(['error'=>$validator->errors()->all()]);
        //     return response()->json(['error'=>$validator->errors()->all()]);
        // }

        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Update Jabatan',
                'fitur' => 'jabatan'
            ]);
            $jabatan = Jabatan::find($request->id_ubah);
            $jabatan->nama_jabatan = $request->nama_jabatan_ubah;
            $jabatan->nilai_bonus_gaji = $request->nilai_bonus_gaji_ubah;

            $jabatan->save();

            DB::commit();
            return back()->with('success', 'Data jabatan telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_jabatan($id_jabatan)
    {
        
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Jabatan',
                'fitur' => 'jabatan'
            ]);
            Jabatan::find($id_jabatan)->delete();
            
            DB::commit();
            return back()->with('success', 'Jabatan telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

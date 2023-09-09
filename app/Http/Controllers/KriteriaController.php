<?php

namespace App\Http\Controllers;

use App\kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function kriteria(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);

         $request->user();
        $kriteria = Kriteria::all();

        return view('kriteria', compact('kriteria'));
    }
    public function tambah_kriteria(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Kriteria',
                'fitur' => 'kriteria'
            ]);
            $kriteria = new Kriteria();
            $kriteria->nama_kriteria = $request->nama_kriteria;

            $kriteria->save();

            DB::commit();
            return back()->with('success', 'Data kriteria baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_kriteria($id_kriteria)
    {
        $kriteria = Kriteria::find($id_kriteria);   
        $arr = json_decode($kriteria, true);

        echo json_encode($arr);

        exit;
    }
    public function ubah_kriteria(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Ubah Kriteria',
                'fitur' => 'kriteria'
            ]);
            $kriteria = Kriteria::find($request->id_kriteria_ubah);
            $kriteria->nama_kriteria = $request->nama_kriteria_ubah;

            $kriteria->save();

            DB::commit();
            return back()->with('success', 'Data kriteria telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_kriteria($id_kriteria)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Kriteria',
                'fitur' => 'kriteria'
            ]);
            Kriteria::find($id_kriteria)->delete();
            
            DB::commit();
            return back()->with('success', 'Kriteria telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\departemen;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function departemen(Request $request)
    {
        $request->user();
        
        $departemen = Departemen::all();

        return view('departemen', compact('departemen'));
    }
    public function tambah_departemen(Request $request)
    {
        DB::beginTransaction();
        try {
            $departemen = new Departemen();
            $departemen->nama_departemen = $request->nama_departemen;

            $departemen->save();

            DB::commit();
            return back()->with('success', 'Data departemen baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_departemen($id_departemen)
    {
        
        $departemen = Departemen::find($id_departemen);   
        // $departemen = Departemen::Where('id_departemen','=', $id_departemen)->get();   

        $arr = json_decode($departemen, true);

        echo json_encode($arr);

        exit;
    }
    public function ubah_departemen(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $departemen = Departemen::find($request->id_departemen);
            // // $departemen = Departemen::Where('id_departemen','=', $id_departemen)->get();   
            // dd($departemen);
            $departemen->nama_departemen = $request->nama_departemen_ubah;

            $departemen->save();

            DB::commit();
            return back()->with('success', 'Data departemen telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_departemen($id_departemen)
    {
        
        DB::beginTransaction();
        try {
            Departemen::find($id_departemen)->delete();
            
            DB::commit();
            return back()->with('success', 'Departemen telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    // public function hapus_departemen($id_departemen)
    // {
    //     //delete post by ID
    //     Post::where('id', $id)->delete();

    //     //return response
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Post Berhasil Dihapus!.',
    //     ]); 
    // }
}

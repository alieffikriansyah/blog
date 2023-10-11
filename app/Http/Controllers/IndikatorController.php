<?php

namespace App\Http\Controllers;

use App\indikator;
use App\kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class IndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indikator(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
    
        $request->user();
        $indikator = Indikator::all();
        $kriteria = Kriteria::all();

        return view('indikator', compact('indikator', 'kriteria'));
    }
    public function tambah_indikator(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Indikator',
                'fitur' => 'indikator'
            ]);
            $indikator = new Indikator();
            $indikator->nama_indikator = $request->nama_indikator;
            $indikator->kriteria_id_kriteria = $request->kriteria;

            $indikator->save();

            DB::commit();
            return back()->with('success', 'Data indikator baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_indikator($id_indikator)
    {
       
        $indikator = Indikator::find($id_indikator);
        $arr = json_decode($indikator, true);

        $kriteria = Kriteria::all();
        $arr['kriteria'] = $kriteria;

        echo json_encode($arr);

        exit;
    }
    public function ubah_indikator(Request $request)
    {

        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Update Indikator',
                'fitur' => 'indikator'
            ]);
            $indikator = Indikator::find($request->id_indikator_ubah);
            $indikator->nama_indikator = $request->nama_indikator_ubah;
            $indikator->kriteria_id_kriteria = $request->kriteria_ubah;

            $indikator->save();

            DB::commit();
            return back()->with('success', 'Data indikator telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
        }
    public function hapus_indikator($id_indikator)
    {
        DB::beginTransaction();
        try {
            \App\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Indikator',
                'fitur' => 'indikator'
            ]);
            Indikator::find($id_indikator)->delete();
            
            DB::commit();
            return back()->with('success', 'Indikator telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}

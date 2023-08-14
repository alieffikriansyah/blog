<?php

namespace App\Http\Controllers;

use App\formPenilaian;
use App\detilFormPenilaian;
use App\indikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormPenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function form_penilaian(Request $request)
    {
      

        $request->user();
        $formPenilaian = FormPenilaian::all();
        $indikator = DB::select('
        SELECT id_indikator, nama_indikator, nama_kriteria
        FROM indikator 
        INNER JOIN kriteria ON indikator.kriteria_id_kriteria = kriteria.id_kriteria
    ');

    return view('formPenilaian', compact('formPenilaian', 'indikator'));
    }

      
    public function tambah_form_penilaian(Request $request)
    {
        DB::beginTransaction();
        try {
            $formPenilaian = new FormPenilaian();
            $formPenilaian->nama_form_penilaian = $request->nama_form_penilaian;

            $formPenilaian->save();

            DB::commit();
            return back()->with('success', 'Data form_penilaian baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function get_ubah_form_penilaian($idform_penilaian)
    {
        $form_penilaian = FormPenilaian::find($idform_penilaian);   
        $arr = json_decode($form_penilaian, true);

        echo json_encode($arr);

        exit;
    }
    public function ubah_form_penilaian(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $form_penilaian = FormPenilaian::find($request->id_form_penilaian_ubah);
            $form_penilaian->nama_form_penilaian = $request->nama_form_penilaian_ubah;

            $form_penilaian->save();

            DB::commit();
            return back()->with('success', 'Data form_penilaian telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
    public function hapus_form_penilaian($idform_penilaian)
    {
        // dd($idform_penilaian);
        DB::beginTransaction();
        try {
            FormPenilaian::find($idform_penilaian)->delete();
            
            DB::commit();
            return back()->with('success', 'FormPenilaian telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }

    public function get_ubah_detil_form_penilaian($id_detil_form_penilaian)
    {
        $detil_form_penilaian = DB::select('
            SELECT id_detil_form_penilaian , nama_indikator, nama_kriteria
            FROM detil_form_penilaian
            INNER JOIN indikator ON detil_form_penilaian.indikator_id_indikator = indikator.id_indikator
            INNER JOIN kriteria ON indikator.kriteria_id_kriteria = kriteria.id_kriteria
            WHERE form_penilaian_idform_penilaian = (?)
        ', [$id_detil_form_penilaian]);
        // var_dump($detil_form_penilaian);

        echo json_encode($detil_form_penilaian);

        exit;
    }

    public function hapus_detil_form_penilaian($id_detil_form_penilaian)
    {
        DB::beginTransaction();
        try {
            DetilFormPenilaian::find($id_detil_form_penilaian)->delete();
            
            DB::commit();
            return back()->with('success', 'Detil Form Penilaian telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }

    public function tambah_detil_form_penilaian(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $detail_form_penilaian = new DetilFormPenilaian();
            
            $detail_form_penilaian->form_penilaian_idform_penilaian = $request->id_form_penilaian_tambah;
            $detail_form_penilaian->indikator_id_indikator = $request->indikator;

            $detail_form_penilaian->save();

            DB::commit();
            return back()->with('success', 'Data form_penilaian baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
 

 
}
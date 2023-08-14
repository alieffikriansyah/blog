<?php

namespace App\Http\Controllers;

use App\absensi;
use App\penilaian;
use App\formPenilaian;
use App\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;


class PenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function penilaian(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();

        $penilaian = Penilaian::all();
        $karyawan = Karyawan::all();
        $formPenilaian = FormPenilaian::all();

        // dd($penilaian[0]->formPenilaian);

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $days = date('d');
        $months = date('m');
        $months_name = date('M');
        $years = date('Y');

        $arrDays = [];
        $arrTimes = [];
        $allAbsenPerDay = [];

        for ($i = 1; $i <= $days_in_month; $i++) {
            $tempDate = date_create($years . "-" . $months . "-" . $i);
            array_push($arrDays, date_format($tempDate, "l, jS F Y"));
            array_push($arrTimes, $tempDate->format('Y-m-d'));

            $absen = DB::select('
                SELECT nama_form_penilaian, nama, id_penilaian, waktu_penilaian, periode_penilaian, nilai_skor, nama_penilai
                FROM penilaian
                INNER JOIN karyawan ON penilaian.karyawan_id_karyawan = karyawan.id_karyawan
                INNER JOIN form_penilaian ON penilaian.form_penilaian_idtable1  = form_penilaian.idform_penilaian
                AND MONTH(waktu_penilaian) = MONTH(?) 
                AND YEAR(waktu_penilaian) = YEAR(?)
            ', [$tempDate, $tempDate]);

            array_push($allAbsenPerDay, $absen);
        }
        return view(
            'penilaian',
            compact('penilaian', 'formPenilaian', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan')
        );
    }

    public function penilaianWithDate(Request $request)
    {
        $request->user();
        $paths = explode('-', $request->query('date'));

        $months = date('m');
        $years = date('Y');

        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }

        $penilaian = Penilaian::all();

        $formPenilaian = DB::select('
            SELECT idform_penilaian,nama_form_penilaian
            FROM form_penilaian
            
        ');
        // $karyawan = DB::select('
        //     SELECT nama, nama_departemen, nama_jabatan, id_karyawan
        //     FROM karyawan
        //     INNER JOIN departemen on karyawan.departemen_id_departemen = departemen.id_departemen
        //     INNER JOIN jabatan on karyawan.jabatan_id_jabatan = jabatan.id_jabatan
        // ');
        $karyawan = Karyawan::all();


        // var_dump($months, $years);
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $arrDays = [];
        $arrTimes = [];

        $tempDate = date_create($years . "-" . $months);
        array_push($arrDays, date_format($tempDate, "l, jS F Y"));
        array_push($arrTimes, $tempDate->format('Y-m-d'));

        $penilaianPerMonth = DB::select('
            SELECT nama_form_penilaian, nama, nama_departemen, nama_jabatan, id_penilaian, waktu_penilaian, periode_penilaian, nilai_skor, nama_penilai, form_penilaian_idtable1
            FROM penilaian
            INNER JOIN karyawan ON penilaian.karyawan_id_karyawan = karyawan.id_karyawan
            INNER JOIN departemen on karyawan.departemen_id_departemen = departemen.id_departemen
            INNER JOIN jabatan on karyawan.jabatan_id_jabatan = jabatan.id_jabatan
            INNER JOIN form_penilaian ON penilaian.form_penilaian_idtable1 = form_penilaian.idform_penilaian
            AND MONTH(waktu_penilaian) = MONTH(?) 
            AND YEAR(waktu_penilaian) = YEAR(?)
        ', [$tempDate, $tempDate]);

        // var_dump($penilaianPerMonth);

        $penilaian = $penilaianPerMonth;
        return view('penilaian', compact('penilaian', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'penilaianPerMonth', 'karyawan', 'formPenilaian'));
    }

    public function tambah_penilaian(Request $request)
    {
        DB::beginTransaction();
        try {
            $Penilaian = new Penilaian();
            $Penilaian->karyawan_id_karyawan = $request->karyawan;
            $Penilaian->form_penilaian_idtable1 = $request->idform_penilaian;
            $Penilaian->waktu_penilaian = $request->waktu_penilaian;
            $Penilaian->periode_penilaian = $request->periode_penilaian;
            $Penilaian->nama_penilai = $request->nama_penilai;
            $Penilaian->nilai_skor = $request->nilai_skor;

            $Penilaian->save();

            DB::commit();
            return back()->with('success', 'Data Penilaian baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }


    // public function terima_penilaian(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $Penilaian = Penilaian::find($request->id);
    //         $Penilaian->status_cuti = 'terima';

    //         if ($Penilaian->absensi_id_absensi) {
    //             $Penilaian->save();

    //             DB::commit();
    //             return back()->with('success', 'Data Penilaian telah berhasil diterima');
    //         }

    //         $absensi = new Absensi();
    //         $absensi->karyawan_id_karyawan = $Penilaian->karyawan_id_karyawan;
    //         $absensi->tanggaldanwaktu_absensi = $Penilaian->waktu_penilaian;
    //         $absensi->tipe_absensi = 'cuti';
    //         $absensi->save();

    //         $Penilaian->absensi_id_absensi = $absensi->id_absensi;

    //         $Penilaian->save();


    //         DB::commit();
    //         return back()->with('success', 'Data Penilaian telah berhasil diterima');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
    //     }
    // }

    // public function tolak_penilaian(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $Penilaian = Penilaian::find($request->id);
    //         $Penilaian->status_cuti = 'tolak';

    //         if ($Penilaian->absensi_id_absensi) {
    //             Absensi::find($Penilaian->absensi_id_absensi)->delete();
    //             $Penilaian->absensi_id_absensi= NULL;
    //         }

    //         $Penilaian->save();

    //         DB::commit();
    //         return back()->with('success', 'Data Penilaian telah berhasil ditolak');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
    //     }
    // }

    public function get_ubah_penilaian($id_penilaian)
    {
        $Penilaian = Penilaian::find($id_penilaian);

        echo json_encode($Penilaian);

        exit;
    }


    // public function get_absen_penilaian($day)
    // {
    //     $time = strtotime($day);
    //     $time = date('Y-m-d', $time);

    //     $absen_todays = DB::select('
    //         SELECT *
    //         FROM Penilaian 
    //         INNER JOIN karyawan ON Penilaian.karyawan_id_karyawan = karyawan.id_karyawan
    //         WHERE DAY(tanggaldanwaktu_penilaian) = DAY(?) 
    //         AND MONTH(tanggaldanwaktu_penilaian) = MONTH(?) 
    //         AND YEAR(tanggaldanwaktu_penilaian) = YEAR(?)
    //     ', [$time, $time, $time]);
    //     echo json_encode($absen_todays);

    //     exit;
    // }

    public function ubah_penilaian(Request $request)
    {
        DB::beginTransaction();
        try {
            $Penilaian = Penilaian::find($request->id_penilaian);
            dd($request->all());
            $Penilaian->karyawan_id_karyawan = $request->karyawan;
            $Penilaian->form_penilaian_idtable1 = $request->idform_penilaian;
            $Penilaian->waktu_penilaian = $request->waktu_penilaian;
            $Penilaian->periode_penilaian = $request->periode_penilaian;
            $Penilaian->nama_penilai = $request->nama_penilai;
            $Penilaian->nilai_skor = $request->nilai_skor;


            $Penilaian->save();

            DB::commit();
            return back()->with('success', 'Data Penilaian telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function hapus_penilaian($id_penilaian)
    {
        DB::beginTransaction();
        try {
            Penilaian::find($id_penilaian)->delete();

            DB::commit();
            return back()->with('success', 'Penilaian telah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }

    public function ubah_penilaian_nilai(Request $request)
    {
        $requestBody = explode('&', $request->getContent());

        $result = 0;

        foreach ($requestBody as $key) {
            if (str_contains($key, 'nilai_detail')) {
                $result += explode("=", $key)[1];
            }
        }

        DB::beginTransaction();
        try {
            $penilaian = Penilaian::find($request->id_penilaian_nilai);
            $detailFormPenilaians = DB::select('
                SELECT *
                FROM detil_form_penilaian 
                WHERE form_penilaian_idform_penilaian = (?)
            ', [$request->id_form_penilaian_nilai]);

            $detailFormPenilaiansCount = count($detailFormPenilaians);

            if ($detailFormPenilaiansCount > 0) {
                $penilaian->nilai_skor = $result / ($detailFormPenilaiansCount * 5) * 100;
            }

            $penilaian->save();

            DB::commit();
            return back()->with('success', 'Data penilaian telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pengajuanCuti;
use App\karyawan;
use App\Absensi;
use Illuminate\Support\Facades\DB;

class PengajuanCutiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function PengajuanCuti(Request $request)
    {
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();

        $PengajuanCuti = pengajuanCuti::all();
        $karyawan = karyawan::all();

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
                SELECT idpengajuan_cuti ,karyawan_id_karyawan, nama, tanggal_mulai_cuti, keterangan_cuti, status_cuti
                FROM pengajuan_cuti
                INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
                AND MONTH(tanggal_mulai_cuti) = MONTH(?) 
                AND YEAR(tanggal_mulai_cuti) = YEAR(?)
            ', [$tempDate, $tempDate]);

            array_push($allAbsenPerDay, $absen);
        }

        // var_dump($countAbsenPerDays);

        return view(
            'PengajuanCuti',
            compact('PengajuanCuti', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan')
        );
    }

    public function pengajuanCutiWithDate(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $paths = explode('-', $request->query('date'));

        // to get current month and year
        $months = date('m');
        $years = date('Y');

        if (count($paths) > 1) {
            $months = (int)$paths[1];
            $years = (int)$paths[0];
        }

        // var_dump($date);
        // return;

        // var_dump($paths);

        $PengajuanCuti = PengajuanCuti::all();
        $karyawan = Karyawan::all();

        // var_dump($months, $years);

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $arrDays = [];
        $arrTimes = [];

        $tempDate = date_create($years . "-" . $months);
        array_push($arrDays, date_format($tempDate, "l, jS F Y"));
        array_push($arrTimes, $tempDate->format('Y-m-d'));

        $cutiPerMonth = DB::select('
            SELECT idpengajuan_cuti ,karyawan_id_karyawan, nama, tanggal_cuti, keterangan_cuti, status_cuti
            FROM pengajuan_cuti
            INNER JOIN karyawan ON pengajuan_cuti.karyawan_id_karyawan = karyawan.id_karyawan
            AND MONTH(tanggal_cuti) = MONTH(?) 
            AND YEAR(tanggal_cuti) = YEAR(?)
        ', [$tempDate, $tempDate]);

        // var_dump($cutiPerMonth);

        return view('pengajuanCutis', compact('PengajuanCuti', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'cutiPerMonth', 'karyawan'));
    }

    public function tambah_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            $PengajuanCuti = new PengajuanCuti();
            $PengajuanCuti->status_cuti = 'pending';
            $PengajuanCuti->karyawan_id_karyawan = $request->karyawan;
            $PengajuanCuti->tanggal_mulai_cuti = $request->tanggal_mulai_cuti;
            $PengajuanCuti->tanggal_selesai_cuti = $request->tanggal_selesai_cuti;

            if ($request->keterangan_cuti) {
                $PengajuanCuti->keterangan_cuti = $request->keterangan_cuti;
            }

            $PengajuanCuti->save();

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }


    public function terima_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            $PengajuanCuti = PengajuanCuti::find($request->id);
            $PengajuanCuti->status_cuti = 'terima';

            if ($PengajuanCuti->absensi_id_absensi) {
                $PengajuanCuti->save();

                DB::commit();
                return back()->with('success', 'Data PengajuanCuti telah berhasil diterima');
            }

            $PengajuanCuti->save();


            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil diterima');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }

    public function tolak_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            $PengajuanCuti = PengajuanCuti::find($request->id);
            $PengajuanCuti->status_cuti = 'tolak';

            $PengajuanCuti->save();

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil ditolak');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }

    public function get_ubah_pengajuanCuti($id_pengajuanCuti)
    {
        $PengajuanCuti = PengajuanCuti::find($id_pengajuanCuti);
        $arr = json_decode($PengajuanCuti, true);

        $karyawan = Karyawan::all();
        $arr['karyawan'] = $karyawan;

        echo json_encode($arr);

        exit;
    }


    public function get_absen_pengajuanCuti($day)
    {
        $time = strtotime($day);
        $time = date('Y-m-d', $time);

        $absen_todays = DB::select('
            SELECT *
            FROM PengajuanCuti 
            INNER JOIN karyawan ON PengajuanCuti.karyawan_id_karyawan = karyawan.id_karyawan
            WHERE DAY(tanggaldanwaktu_pengajuanCuti) = DAY(?) 
            AND MONTH(tanggaldanwaktu_pengajuanCuti) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_pengajuanCuti) = YEAR(?)
        ', [$time, $time, $time]);
        echo json_encode($absen_todays);

        exit;
    }

    public function ubah_pengajuanCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            $PengajuanCuti = PengajuanCuti::find($request->id_ubah);
            $PengajuanCuti->karyawan_id_karyawan = $request->karyawan_ubah;
            $PengajuanCuti->tanggaldanwaktu_pengajuanCuti = $request->tanggaldanwaktu_pengajuanCuti_ubah;
            $PengajuanCuti->tipe_pengajuanCuti = $request->tipe_pengajuanCuti_ubah;
            $PengajuanCuti->keterangan_pengajuanCuti = $request->keterangan_pengajuanCuti_ubah;
            $PengajuanCuti->status_hari = $request->status_hari_ubah;
            $PengajuanCuti->keterangan_cuti = $request->keterangan_cuti_ubah;

            $PengajuanCuti->save();

            DB::commit();
            return back()->with('success', 'Data PengajuanCuti telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function hapus_pengajuanCuti($id_pengajuanCuti)
    {
        DB::beginTransaction();
        try {
            PengajuanCuti::find($id_pengajuanCuti)->delete();

            DB::commit();
            return back()->with('success', 'PengajuanCuti telah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
}

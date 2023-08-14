<?php

namespace App\Http\Controllers;

use App\absensi;
use App\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function absensi(Request $request)
    {
        // dd($request);
        // $request->user()->authorizeRoles(['superadmin', 'admin']);
        $request->user();

        $absensi = Absensi::all();
        $karyawan = Karyawan::all();

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
                SELECT karyawan_id_karyawan, nama, tipe_absensi
                FROM absensi 
                INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
                WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
                AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
                AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
            ', [$tempDate, $tempDate, $tempDate]);

            array_push($allAbsenPerDay, $absen);
        }

        // var_dump($countAbsenPerDays);

        return view(
            'absensi',
            compact('absensi', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan')
        );
    }

    public function absensiWithDate(Request $request)
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


        // var_dump($date);
        // return;

        // var_dump($paths);



        $absensi = Absensi::all();
        $karyawan = Karyawan::all();

        // var_dump($months, $years);

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $arrDays = [];
        $arrTimes = [];
        $allAbsenPerDay = [];

        for ($i = 1; $i <= $days_in_month; $i++) {
            $tempDate = date_create($years . "-" . $months . "-" . $i);
            array_push($arrDays, date_format($tempDate, "l, jS F Y"));
            array_push($arrTimes, $tempDate->format('Y-m-d'));

            $absen = DB::select('
                SELECT karyawan_id_karyawan, nama, tipe_absensi
                FROM absensi 
                INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
                WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
                AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
                AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
            ', [$tempDate, $tempDate, $tempDate]);

            array_push($allAbsenPerDay, $absen);
        }

        // var_dump($countAbsenPerDays);

        return view('absensi', compact('absensi', 'days_in_month', 'months', 'years', 'arrDays', 'arrTimes', 'allAbsenPerDay', 'karyawan'));
    }

    public function tambah_absensi(Request $request)
    {
        DB::beginTransaction();
        try {
            $absensi = new Absensi();
            $absensi->karyawan_id_karyawan = $request->karyawan;
            $absensi->tanggaldanwaktu_absensi = $request->tanggaldanwaktu_absensi;
            $absensi->tipe_absensi = $request->tipe_absensi;
            if ($request->keterangan_absensi) {
                $absensi->keterangan_absensi = $request->keterangan_absensi;
            }
            $absensi->status_hari = $request->status_hari;

            // if ($request->keterangan_cuti) {
            // $absensi->keterangan_cuti = $request->keterangan_cuti;
            // }

            $absensi->save();

            DB::commit();
            return back()->with('success', 'Data absensi baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function get_ubah_absensi($id_absensi)
    {
        $absensi = Absensi::find($id_absensi);
        $arr = json_decode($absensi, true);

        $karyawan = Karyawan::all();
        $arr['karyawan'] = $karyawan;

        echo json_encode($arr);

        exit;
    }


    public function get_absen_absensi($day)
    {
        $time = strtotime($day);
        $time = date('Y-m-d', $time);

        $absen_todays = DB::select('
            SELECT *
            FROM absensi 
            INNER JOIN karyawan ON absensi.karyawan_id_karyawan = karyawan.id_karyawan
            WHERE DAY(tanggaldanwaktu_absensi) = DAY(?) 
            AND MONTH(tanggaldanwaktu_absensi) = MONTH(?) 
            AND YEAR(tanggaldanwaktu_absensi) = YEAR(?)
        ', [$time, $time, $time]);
        echo json_encode($absen_todays);

        exit;
    }
    public function ubah_absensi(Request $request)
    {
        DB::beginTransaction();
        try {
            $absensi = Absensi::find($request->id_ubah);
            $absensi->karyawan_id_karyawan = $request->karyawan_ubah;
            $absensi->tanggaldanwaktu_absensi = $request->tanggaldanwaktu_absensi_ubah;
            $absensi->tipe_absensi = $request->tipe_absensi_ubah;
            $absensi->keterangan_absensi = $request->keterangan_absensi_ubah;
            $absensi->status_hari = $request->status_hari_ubah;
            // $absensi->keterangan_cuti = $request->keterangan_cuti_ubah;

            $absensi->save();

            DB::commit();
            return back()->with('success', 'Data absensi telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
    public function hapus_absensi($id_absensi)
    {
        DB::beginTransaction();
        try {
            Absensi::find($id_absensi)->delete();

            DB::commit();
            return back()->with('success', 'Absensi telah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: ' . $e);
        }
    }
}

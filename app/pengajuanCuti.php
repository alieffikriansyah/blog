<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengajuanCuti extends Model
{
    protected $table = "pengajuan_cuti";
    protected $primaryKey = 'idpengajuan_cuti';

    public $timestamps = false;

    public function absensi()
    {
        return $this->belongsTo('App\Absensi', 'absensi_id_absensi', 'id_absensi');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Karyawan', 'karyawan_id_karyawan', 'id_karyawan');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $table = "penjualan";

    protected $primaryKey = 'id_penjualan';

    public $timestamps = false;

    public function karyawan()
    {
        return $this->belongsTo('App\Karyawan', 'karyawan_id_karyawan', 'id_karyawan');
    }
}

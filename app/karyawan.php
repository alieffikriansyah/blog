<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = "karyawan";
    protected $primaryKey = "id_karyawan";

    public $timestamps = false;

    public function departemen()
    {
        return $this->belongsTo('App\Departemen', 'departemen_id_departemen', 'id_departemen');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan', 'jabatan_id_jabatan', 'id_jabatan');
    }
  
}

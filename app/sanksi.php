<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sanksi extends Model
{
    protected $table = "sanksi";

    protected $primaryKey = 'id_sanksi';

    public $timestamps = false;

    public function karyawan()
    {
        return $this->belongsTo('App\Karyawan', 'karyawan_id_karyawan', 'id_karyawan');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }
    
}

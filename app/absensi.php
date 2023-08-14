<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    protected $table = "absensi";
    protected $primaryKey = 'id_absensi';

    public $timestamps = false;
}

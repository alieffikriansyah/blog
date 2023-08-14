<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class indikator extends Model
{
    protected $table = "indikator";
    protected $primaryKey = 'id_indikator';
    public $timestamps = false;

    public function kriteria()
    {
        return $this->belongsTo('App\Kriteria', 'kriteria_id_kriteria', 'id_kriteria');
    }
}

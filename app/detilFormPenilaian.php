<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilFormPenilaian extends Model
{
    protected $table = "detil_form_penilaian";
    protected $primaryKey = 'id_detil_form_penilaian';

    public $timestamps = false;

    public function formPenilaian()
    {
        return $this->belongsTo('App\FormPenilaian', 'form_penilaian_idform_penilaian', 'idform_penilaian');
    }

    public function indikator()
    {
        return $this->belongsTo('App\Indikator', 'indikator_id_indikator', 'id_indikator');
    }
}

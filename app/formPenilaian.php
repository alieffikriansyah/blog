<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formPenilaian extends Model
{
    protected $table = "form_penilaian";
    protected $primaryKey = 'idform_penilaian';

    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{
    protected $table = "departemen";
    protected $primaryKey = "id_departemen";

    public $timestamps = false;
}

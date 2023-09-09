<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $table = "admin";
    protected $primaryKey = "id_admin";

    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id_user', 'id');
    }
}

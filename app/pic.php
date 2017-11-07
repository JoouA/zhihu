<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pic extends Model
{
    protected $table = 'pics';

    public function users(){

        return $this->belongsToMany('App\User','favorites');

    }


}

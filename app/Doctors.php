<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    //
    public function claims()
    {
    	return $this->hasMany('Claims', 'doctor_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }
}

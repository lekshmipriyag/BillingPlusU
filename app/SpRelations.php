<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpRelations extends Model
{
    //
    public function specialist()
    {
        return $this->belongsTo('App\Users', 'specialist_id');
    }

    public function processor()
    {
        return $this->belongsTo('App\Users', 'processor_id');
    }
}

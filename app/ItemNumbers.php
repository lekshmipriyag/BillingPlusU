<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemNumbers extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }
}

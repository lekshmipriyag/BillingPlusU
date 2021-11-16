<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteLists extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }
}

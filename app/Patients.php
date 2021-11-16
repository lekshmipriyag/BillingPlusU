<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    //
    protected $casts = [
        'birthday'  => 'date:Y-m-d',
    ];

}

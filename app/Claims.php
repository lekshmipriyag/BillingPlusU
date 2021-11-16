<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claims extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_services' => 'date:Y-m-d',
        'referral_date' => 'date:Y-m-d'
    ];

    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctors', 'doctor_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Locations', 'location_id');
    }
}

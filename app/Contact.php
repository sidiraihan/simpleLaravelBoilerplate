<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'city',
        'country',
        'job_title',
        'owner'   
    ];

    public function ownerData()
    {
        return $this->belongsTo('App\User', 'owner');
    }
}

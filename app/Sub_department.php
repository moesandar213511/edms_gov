<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_department extends Model
{
    protected $fillable=[
        'name',
        'main_depart_id',
        'office_phone',
        'human_phone',
        'address',
        'logo',
        'latitude',
        'longitude'
    ];

    public function type(){
        return $this->hasOne("App\User",'data_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main_department extends Model
{
    protected $fillable=[
        'depart_name'
    ];

    public function subDepartments(){
        return $this->hasMany('App\Sub_department','main_depart_id');
    }
}

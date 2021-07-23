<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter_sub_department extends Model
{
    protected $fillable=[
       'letter_id',
       'in_sub_depart_id',
       'out_sub_depart_id',
       'type'
    ];

    public function letter(){
        return $this->belongsTo('App\Letter');
    }
}

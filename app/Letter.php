<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable=[
        'letter_no',
        'date',
        'title',
        'purpose_letter',
        'detail',
        'attach_file',
        'key_code',
        'type'
    ];

    public function subDepartmentLetters(){
        return $this->hasMany('App\Letter_sub_department','letter_id');
    }

}

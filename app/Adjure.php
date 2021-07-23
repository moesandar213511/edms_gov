<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjure extends Model
{
    protected $fillable=[
        'title',
        'file',
        'description'
    ];
}

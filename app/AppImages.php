<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppImages extends Model
{
    protected $fillable = ['filename'];

    protected $guarded = [];

    public function getFilenameAttribute($value){
        return $value != null ?  asset('images/app_images/'. $value) : asset('images/default.png') ;
    }

}

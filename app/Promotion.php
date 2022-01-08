<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $fillable = ['promotion_title', 'promotion_link' ];
    
    // protected $guarded = [];

    public function getFilenameAttribute($value){
        return $value != null ?  asset('images/promotion/'. $value) : asset('images/default.png') ;
    }


}

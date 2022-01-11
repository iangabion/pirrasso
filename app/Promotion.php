<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $fillable = ['promotion_title', 'promotion_link', 'image' ];
    
    // protected $guarded = [];

    public function getImageAttribute($value){
        return $value != null ?  asset('images/promotion/'. $value) : asset('images/default.png') ;
    }


}

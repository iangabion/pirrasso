<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //
    public function items(){
		return $this->hasMany(Items::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getIconAttribute($value) {
      return $value != null ?  asset('images/icons/'. $value) : asset('images/default.png') ;
    }
}

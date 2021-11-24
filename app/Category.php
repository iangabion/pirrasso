<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $guarded = [];
    //relation
	public function items(){
		return $this  ->hasMany(Items::class);
	}
	public function subcategories(){
		return $this  ->hasMany(Subcategory::class);
    }

    public function getIconAttribute($value) {
        return $value != null ?  asset('images/icons/'. $value) : null ;
    }
}

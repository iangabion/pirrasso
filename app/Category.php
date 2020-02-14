<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //relation
	public function items(){
		return $this->hasMany(Items::class);
	}
	public function subcategories(){
		return $this->hasMany(Subcategory::class);
	}
}

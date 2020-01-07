<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //

	public function item(){
		return $this->belongsTo(Items::class);
	}
}

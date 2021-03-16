<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    protected $appends = ['link'];

	public function item(){
		return $this->belongsTo(Items::class);
	}
    public function getLinkAttribute(){
        return asset('images/items/'. $this->filename);
    }
}

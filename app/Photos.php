<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    protected $fillable = ['filename', 'imageable_id', 'imageable_type' ];
    protected $appends = ['link'];

    public function imageable()
    {
        return $this->morphTo();
    }
    public function getFilenameAttribute($value){
        return $value != null ?  asset('images/items/'. $value) : asset('images/default.png') ;
    }
    public function getLinkAttribute($value){
        return  $value != null ? asset($this->filename) : asset('images/items/default.png') ;
    }
    public function item(){
		return $this->belongsTo(Items::class);
	}

}

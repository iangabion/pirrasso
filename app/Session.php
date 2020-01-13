<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	public function messages(){
        return $this->hasMany(Message::class);
    }
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function clients(){
        return $this->belongsTo(Client::class);
    }
}

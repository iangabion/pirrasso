<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    //
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function clients(){
        return $this->belongsTo(Client::class);
    }
}

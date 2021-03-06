<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function session(){
        return $this->belongsTo(Session::class);
    }


    // // mutator
    // public function getCreatedatAttribute($value) {
    //     return date('d F Y H:i', strtotime($value)) ;
    // }
}

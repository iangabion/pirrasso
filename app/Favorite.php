<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //

    public function client_fav(){
        return $this->belongsToMany(Client::class);
    }
}

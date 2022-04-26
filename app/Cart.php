<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [ 'user_id', 'item_id', 'quantity', 'description'];

    public function item_cart(){
        return $this->belongsTo(Items::class);
    }
    public function user_cart(){
        return $this->belongsToMany(Client::class);

    }
}

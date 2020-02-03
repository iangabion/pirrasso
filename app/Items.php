<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    //

    // scopes
    public function scopeTitleSearch($query , $searchTerm)
    {
        return $query->where('title', 'like', "%" . $searchTerm . "%");
    }

    // relations
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function clients_fav(){
        return $this->belongsToMany(Client::class , 'favorites' , 'item_id' , 'user_id' );
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function photos(){
        return $this->hasMany(Photos::class);
    }

    public function sessions(){
        return $this->hasMany(Session::class);
    }
    public function solds(){
        return $this->hasMany(Sold::class);
    }


    //mutator
    public function getCreatedatAttribute($value) {
        return date('d F Y H:i', strtotime($value)) ; 
    }
    public function getTitleatAttribute($value) {
        return ucwords($value) ; 
    }


}

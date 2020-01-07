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
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function photos(){
        return $this->hasMany(Photos::class);
    }


}

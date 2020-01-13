<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
     use HasApiTokens, Notifiable;



    // scopes
    public function scopeNameSearch($query , $searchTerm)
    {
        return $query->where('first_name', 'like', "%" . $searchTerm . "%");
    }


    // relations
    public function items(){
        return $this->hasMany(Items::class);
    }
    public function session(){
        return $this->hasMany(Session::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }

    // mutator
    public function getImageAttribute($value){
        return $value ? asset('images/user_profile/'. $value) : asset('images/profile.jpg') ;
    }
    public function getFullnameAttribute($value){
        return ucwords($this->first_name .' '. $this->last_name) ;
    }



}

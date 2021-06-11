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
    public function solds(){
        return $this->hasMany(Sold::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function items_fav(){
        return $this->belongsToMany(Items::class , 'favorites' , 'user_id' , 'item_id' );
    }
    
    public function social_profile(){
        return $this->hasOne(SocialProfile::class);
    }



    // mutator
    public function getImageAttribute($value){
        if(!$this->social_profile()->count() && !$value){
            return 'https://tnsleepteam.com/wp-content/uploads/2016/10/placeholder_profile_male.jpg' ;
        }
        if($value){
            return asset('images/user_profile/'. $value);
        }
    }
    public function getFullnameAttribute($value){
        return ucwords($this->first_name .' '. $this->last_name) ;
    }



}

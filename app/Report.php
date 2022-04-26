<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = ['reason', 'description'];
    // public function report(){
    //     return $this->belongsToMany(Client::class, 'user_id');
    // }
    public function reportedItem(){
        return $this->belongsTo(Items::class);
    }
}

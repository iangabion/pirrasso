<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $table = 'fcm_tokens';
    protected $guarded=[];
    
    public function client(){
        return $this->belongsTo(Client::class);
    }
}

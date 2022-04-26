<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialProfile extends Model
{
    protected $table = 'social_profiles';
    protected $guarded=[];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

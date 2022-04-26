<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    //
    protected $fillable = ['reason'] ;

    public function user_report(){
        return $this->belongsTo(User::class);
    }
}

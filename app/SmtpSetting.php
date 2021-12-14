<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    //
    protected $appends =
        ['is_default'];

    public function getIsDefaultAttribute(){
        if($this->status_on == 0){
            return false;
        }

        return true;
    }
}

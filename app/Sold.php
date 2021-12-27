<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    //
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function clients(){
        return $this->belongsTo(Client::class);
    }
    public function reviews(){
        return $this->belongsTo(ProductReview::class);
    }

    public function getStatusIdAttribute($value) {
        switch($value) {
            case 1 : return 'Processing'; break;
            case 2 : return 'Delivering'; break;
            case 3 : return 'Completed'; break;
        }
    }
}

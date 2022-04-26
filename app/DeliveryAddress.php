<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    //
    protected $fillable = [
        'user_id', 'address', 'phone', 'postal_code', 'street', 'label_as'
    ];
}

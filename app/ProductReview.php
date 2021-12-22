<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    //
    protected $table = 'product_reviews';

    // protected $fillable = [
    //     'solds_id', 'buyer_id', 'seller_id', 'items_id', 'rating', 'review_description'
    // ];
    public function item(){
        return $this->belongsTo(Items::class);
    }
}

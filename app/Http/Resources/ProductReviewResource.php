<?php

namespace App\Http\Resources;

use App\ProductReview;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $count = ProductReview::where('is_read', 0)->count();
        return [
            'id'=> $this->id,
            'solds_id'=> $this->solds_id,
            'seller_id'=> $this->seller_id,
            'items_id'=> $this->items_id,
            'buyer_id'=> $this->buyer_id,
            'rating'=> $this->rating,
            'review_description'=> $this->review_description,
            'is_read'=> $this->is_read,
            'unread_review_notifications'=> $count
        ];
    }
}

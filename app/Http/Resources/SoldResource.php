<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ItemResource ;

use App\Client ;

class SoldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $buyer = Client::findorfail($this->buyer_id); 
        $seller = Client::findorfail($this->seller_id);

        return [
            'items' => $this->item ? new ItemResource($this->item) : 'wara'  ,
            'buyer' => $buyer ,
            'seller' => $seller,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MessageResource ;
use App\Http\Resources\PhotoResource ;
use App\Client ;


class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $buyer = Client::findorfail($this->buyer_id); 
        $seller = Client::findorfail($this->seller_id); 

        return [
            'session_id'=> $this->id,
            'session_name'=> $this->sessions_name,
            'item_id' => $this->item->id,
            'item_name' => $this->item->title,
            'item_price' => $this->item->price,
            'users' => [$buyer , $seller],
            'photo' =>$this->item->photos != null ? PhotoResource::collection($this->item->photos)[0] : '' , 
            'messages' => $this->messages ? MessageResource::collection($this->messages) : ''  ,
            'buyer_id' => $buyer->id ,
            'seller_id' => $seller->id ,
        ];
    }
}

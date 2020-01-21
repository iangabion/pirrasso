<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MessageResource ;
use App\Http\Resources\PhotoResource ;


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
        return [
            'session_id'=> $this->id,
            'session_name'=> $this->sessions_name,
            'item_id' => $this->item->id,
            'item_name' => $this->item->title,
            'item_price' => $this->item->price,
            'photos' =>isset($this->item->photos) ? PhotoResource::collection($this->item->photos)[0] : '' , 
            'messages' => $this->messages ? MessageResource::collection($this->messages) : ''  ,
        ];
    }
}

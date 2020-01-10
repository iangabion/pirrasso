<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PhotoResource ;
use App\Http\Resources\ClientResource ;
// use Illuminate\Support\Facades\Auth;

class ItemResource extends JsonResource
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
            'id'=> $this->id,
            'title'=> $this->title,
            'price'=> $this->price,
            'description'=> $this->description,
            'location'=> $this->location,
            'status'=> $this->status->name,
            'category' => $this->category->name ,
            'published at' => $this->created_at ,

            'owner' => new ClientResource($this->client),
            'images' =>isset($this->photos) ? PhotoResource::collection($this->photos) : '' , 

        ];
    }
}

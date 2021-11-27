<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PhotoResource ;
use App\Http\Resources\ClientResource ;
// use Illuminate\Support\Facades\Auth;
use App\Apartment ;
use App\Vehicle ;

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

        $apartment = Apartment::where('item_id' , $this->id)->first();
        $vehicle = Vehicle::where('item_id' , $this->id)->first();
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'price'=> $this->price,                                                                                                          
            'stock'=> $this->stock,
            'description'=> $this->description,
            'location'=> $this->location,
            'latitude'=> $this->latitude,
            'longitude'=> $this->longitude,
            'status'=> $this->status->name,
            'category' => $this->category->name ,
            'subcategory' =>  isset($this->subcategory->name) ? $this->subcategory->name : '' ,
            'show_number' => $this->show_number,
            'published at' => $this->created_at ,
            'owner' => new ClientResource($this->client),
            'images' =>isset($this->photos) ? PhotoResource::collection($this->photos) : '' , 
            'apartment_filter' => $apartment ,
            'vehicles_filter' => $vehicle ,
            'is_urgent' => $this->is_urgent,
            'is_displayed' => $this->is_displayed,
            'is_active' => $this->is_active
            
        ];
    }
}

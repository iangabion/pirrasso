<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PhotoResource ;
use App\Http\Resources\ClientResource ;
// use Illuminate\Support\Facades\Auth;
use App\Apartment ;
use App\Vehicle ;
use App\Photos;
use App\Sold;
use App\Client;
use Illuminate\Support\Facades\Auth;

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
        // $client = Client::where('client_id', Auth::id()); 
        $apartment = Apartment::where('item_id' , $this->id)->first();
        $vehicle = Vehicle::where('item_id' , $this->id)->first();
        $photos = Photos::where('items_id', $this->id)->pluck('filename');
        $solds = Sold::where('item_id', $this->id)->get();
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
            'category' => $this->category,
            'subcategory' =>  isset($this->subcategory->name) ? $this->subcategory->name : '' ,
            'show_number' => $this->show_number,
            'published at' => $this->created_at ,
            'solds'=> $solds,
            'owner' => new ClientResource($this->client),
            // 'is_draft' => $this->is_approved,
            // 'images' =>isset($this->photos) ? PhotoResource::collection($this->photos) : '' ,
            'images' => $photos,
            'apartment_filter' => $apartment ,
            'vehicles_filter' => $vehicle ,
            'is_urgent' => $this->is_urgent,
            'is_displayed' => $this->is_displayed,
            'is_active' => $this->is_active,
            'variation'=> $this->variation,
           

            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,

            // 'rating'=>$this->rating,
            // 'review_description' => $this->review_description,

        ];
    }
}

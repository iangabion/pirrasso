<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PhotoResource ;
use App\Http\Resources\ClientResource ;
use App\Http\Resources\ProductReviewResource;
// use Illuminate\Support\Facades\Auth;
use App\Apartment ;
use App\Vehicle ;
use App\Photos;
use App\Sold;
use App\ProductReview;
use App\Client;
use App\Report;
use Illuminate\Support\Facades\Auth;

class Item2Resource extends JsonResource
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
     
        $photos = Photos::where('items_id', $this->id)->get();
        $solds = Sold::where('item_id', $this->id)->get();
        $report = Report::where('item_id', $this->id)->get();
        // $reviews = ProductReview::where('items_id', $this->id)->get();
        // $reviews = Client::join('product_reviews','clients.id','=','product_reviews.buyer_id')->where('')->get();
        // $reviews2 = ProductReviewResource::collection($reviews);
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'price'=> $this->price,
            'description'=> $this->description,
            'status'=> $this->status ? $this->status->name : '',
            'category' => $this->category,
            'subcategory' =>  isset($this->subcategory->name) ? $this->subcategory->name : '' ,
            'published at' => $this->created_at ,
            'images' => $photos,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'number_of_report'=>  $this->report_status,
            'report_state' => $this->is_report,
            'report_status'=> $this->is_report == 1 ? 'Item on hold' : 'Available',
            'report'=> $report

        ];
    }
}
